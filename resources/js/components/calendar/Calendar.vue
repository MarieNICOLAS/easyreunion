<template>
    <div class="calendar -ml-3 2xl:ml-0">
        <span class="isolate inline-flex rounded-md shadow-sm mb-8">
            <button
                type="button"
                class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                :class="{'bg-red-300': view === 'month'}"
                @click="
                view = 'month',
                getWeeksByMonthAndYear(true)
                "
            >
                Vue mensuel
            </button>
            <button
                type="button"
                class="relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                :class="{'bg-red-300': view === 'week'}"
                @click="
                view = 'week',
                getWeeksByMonthAndYear(true)
                "
            >
                Vue hebdomadaire
            </button>
        </span>
        <div class="float-right">
            Légende :
            <span class="btn bg-yellow mx-1 h-in">Plusieurs options</span>
            <span class="btn bg-pink mx-1 h-in">Annulation</span>
            <span v-if="isAdmin" class="btn bg-blue mx-1 h-in">Demande</span>
            <span class="btn bg-green mx-1 h-in">Option</span>
            <span class="btn bg-red mx-1 h-in">Confirmation</span>
            <span class="btn bg-orange mx-1 h-in">Option partenaire</span>
            <span class="btn bg-black mx-1 h-in">Confirmation partenaire</span>
        </div>

        <div class="time-selector md:flex mb-2">
            <div class="flex items-center mx-2">
                <a class="btn info h-in" @click="previous">&lt</a>
            </div>
            <div class="flex">
                <div class="mr-2">
                    <select
                        v-model="month"
                        @change="getWeeksByMonthAndYear(true)"
                        id="agendaChangeMonth"
                    >
                        <option value="01">Janvier</option>
                        <option value="02">Février</option>
                        <option value="03">Mars</option>
                        <option value="04">Avril</option>
                        <option value="05">Mai</option>
                        <option value="06">Juin</option>
                        <option value="07">Juillet</option>
                        <option value="08">Août</option>
                        <option value="09">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                </div>
                <div class="mr-2" v-if="view === 'week'">
                    <select v-model="weekSelected" @change="weekChange">
                        <option
                            v-for="(week, i) in weeks"
                            :key="i"
                            :value="week.number"
                            :selected="week.number === weekSelected"
                        >
                            Sem {{ week.number }} -
                            {{ week.readableStartDate }} au
                            {{ week.readableEndDate }}
                        </option>
                    </select>
                </div>
                <div>
                    <select
                        v-model="year"
                        @change="getWeeksByMonthAndYear(true)"
                        id="agendaChangeYear"
                    >
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center mx-2">
                <a class="btn info h-in" @click="next">&gt</a>
            </div>
        </div>

        <div class="flex flex-col xl:flex-row xl:mb-1">
            <div class="mx-4 flex flex-col">
                <div>Espace</div>
                <input
                    v-model="sgFilterSearch"
                    type="text"
                    @change="emptySpaceFilter"
                />
                <select
                    v-show="sgFilterSearch !== ''"
                    v-model="spacesFilter"
                    multiple
                >
                    <option
                        v-for="sG in filteredSpaceGroups"
                        :selected="spacesFilter.includes(sG)"
                    >
                        {{ sG }}
                    </option>
                </select>
            </div>

            <div class="mx-4">
                <div>Ville</div>
                <select v-model="cityFilter">
                    <option v-for="city in availableCities">{{ city }}</option>
                </select>
            </div>

            <div class="mx-4">
                <div>Code postal</div>
                <select v-model="zipFilter">
                    <option v-for="city in availableZips">{{ city }}</option>
                </select>
            </div>

            <div class="flex align-middle items-center justify-center">
                <span class="text-xs italic btn dark h-in" @click="emptyFilters"
                >Désactiver les filtres</span
                >
            </div>
        </div>

        <div
            aria-hidden="true"
            class="floatThead-container z-10 sticky top-0 bg-gray-100"
            style="
                border-collapse: collapse;
                border-color: rgb(244, 244, 244);
                border-style: solid;
                border-width: 1px 1px 0px;
                border-image: none 100% / 1 / 0 stretch;
            "
        >
            <table
                class="table table-bordered table-calendar floatThead-table w-full"
                style="
                    display: table;
                    margin: 0px;
                    table-layout: fixed;
                    min-width: 1230px;
                "
            >
                <colgroup>
                    <col class="w-24 2xl:w-52" />
                    <col
                        v-for="d in header"
                        :style="{ width: 50 / header.length + '%' }"
                    />
                    <col
                        v-for="d in header"
                        :style="{ width: 50 / header.length + '%' }"
                    />
                </colgroup>
                <thead>
                <tr>
                    <th
                        v-for="(colspan, month) in months"
                        :colspan="colspan * 2 + 1"
                    >
                        {{ month }}
                    </th>
                </tr>
                <tr>
                    <th>Salle</th>
                    <th
                        v-for="d in header"
                        colspan="2"
                        style="padding: 3px 0; text-align: center"
                    >
                        <small>{{ d.day }}</small
                        ><br />{{ d.num }}
                    </th>
                </tr>
                </thead>
            </table>
        </div>
        <table
            class="table table-bordered table-calendar w-full"
            style="table-layout: fixed; min-width: 1230px"
        >
            <colgroup>
                <col class="w-24 2xl:w-52" />
                <col
                    v-for="d in header"
                    :style="{ width: 50 / header.length + '%' }"
                />
                <col
                    v-for="d in header"
                    :style="{ width: 50 / header.length + '%' }"
                />
            </colgroup>
            <tbody v-for="agenda in filteredAgendas">
            <tr class="journee divide-x divide-gray-400">
                <td class="salle text-[88%] whitespace-normal" rowspan="2">
                    <a
                        :href="'/partner/spaces/' + agenda.slug"
                        class="flex flex-col"
                    >
                            <span class="font-medium text-gray-900">{{
                                agenda.name
                            }}</span>
                        <span
                            :hidden="1 > capacities[agenda.id].length"
                            class="text-red text-[40%] italic font-medium"
                        >capacité
                                {{ capacities[agenda.id].join(" à ") }}</span
                        >
                    </a>
                </td>

                <td
                    v-for="(day, index) in agendasContents[agenda.id]"
                    :class="
                            'text-center divide-x divide-gray-300' +
                            (isWeekEnd(
                                Object.keys(agendasContents[agenda.id]).indexOf(
                                    index
                                )
                            )
                                ? ` bg-gray-300`
                                : ``)
                        "
                    colspan="2"
                >
                    <a
                        :class="
                                'tooltip-cell text-center pr-1 relative inline-table w-1/2' +
                                (day.am !== undefined
                                    ? ` text-white bg-${
                                          colorStatus[day.am.status]
                                      }`
                                    : '')
                            "
                        href="#"
                        @click.prevent="
                                elementOnClick(
                                    agenda,
                                    index,
                                    day.am?.status ?? 'none',
                                    'am'
                                )
                            "
                        target="_blank"
                        aria-busy="true"
                        :data-elements="JSON.stringify(day?.am?.elements)"
                    ><span class="label">AM </span></a
                    >

                    <a
                        :class="
                                'tooltip-cell text-center pl-1 relative inline-table w-1/2' +
                                (day.pm !== undefined
                                    ? ` text-white bg-${
                                          colorStatus[day.pm.status]
                                      }`
                                    : '')
                            "
                        href="#"
                        @click.prevent="
                                elementOnClick(
                                    agenda,
                                    index,
                                    day.pm?.status ?? 'none',
                                    'pm'
                                )
                            "
                        :data-elements="JSON.stringify(day?.pm?.elements)"
                        aria-busy="true"
                        target="_blank"
                    ><span class="label">PM </span></a
                    >
                </td>
            </tr>
            <tr class="soiree divide-x divide-gray-400">
                <td
                    v-for="(day, index) in agendasContents[agenda.id]"
                    :class="
                            'text-center' +
                            (isWeekEnd(
                                Object.keys(agendasContents[agenda.id]).indexOf(
                                    index
                                )
                            )
                                ? ` bg-gray-300`
                                : ``)
                        "
                    colspan="2"
                >
                    <a
                        :class="
                                'tooltip-cell relative inline-table w-full' +
                                (day.evening !== undefined
                                    ? ` text-white bg-${
                                          colorStatus[day.evening.status]
                                      }`
                                    : '')
                            "
                        href="#"
                        @click.prevent="
                                elementOnClick(
                                    agenda,
                                    index,
                                    day.evening?.status ?? 'none',
                                    'evening'
                                )
                            "
                        :data-elements="
                                JSON.stringify(day?.evening?.elements)
                            "
                        aria-busy="true"
                        target="_blank"
                    ><span class="label">Soirée</span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <CreateAgendaElementModal
        v-if="!isAdmin"
        :agenda-id="addElementAgendaId"
        :show-modal="displayAddElementModal"
        :end-date="newElementSelectedDate"
        :start-date="newElementSelectedDate"
        :time="selectedTime"
        @closeModal="closeAgendaElementsModal"
    />
    <CreateOptionModal
        v-if="isAdmin"
        :end-date="newElementSelectedDate"
        :show-modal="displayAddElementModal"
        :time="selectedTime"
        :agenda-id="addElementAgendaId"
        :start-date="newElementSelectedDate"
        @closeModal="closeAgendaElementsModal"
    />
</template>

<script>
    import CreateAgendaElementModal from "../partner/CreateAgendaElementModal";
    import SpaceFilter from "../admin/filters/SpaceFilter";
    import CreateOptionModal from "../admin/CreateOptionModal";
    import moment from "moment";

    export default {
        name: "Calendar",
        components: { CreateOptionModal, SpaceFilter, CreateAgendaElementModal },
        data() {
            return {
                isAdmin: document.getElementById("baseURL"),

                // Filters
                spacesFilter: [],
                availableCities: [],
                availableZips: [],
                availableSpaceGroups: [],
                cityFilter: "",
                zipFilter: "",
                sgFilterSearch: "",
                startDate: moment().format("YYYY-MM-DD"),
                endDate: moment().format("YYYY-MM-DD"),
                month:
                    localStorage.monthFilter ??
                        this.month2digits(new Date().getMonth() + 1),
                year: localStorage.yearFilter ?? new Date().getFullYear(),
                weeks: [],
                weekSelected: 0,
                firstSaturdayIndex: 0,
                agendas: [],
                agendasContents: {},
                header: [],
                months: [],
                capacities: {},
                byChunk: 6,

                displayAddElementModal: false,
                addElementAgendaId: 0,
                selectedTime: "am",
                newElementSelectedDate: "",
                view: "month",
                status: {
                    request: "Demande",
                    cancelled: "Annulé",
                    reserved: "Réservé",
                    multiple: "Plusieurs options",
                    request_without_followup: "Demande sans suivi",
                    confirmation: "Confirmation",
                    cancelation: "Annulation",
                    partner_option: "Option partenaire",
                    partner_options: "Option partenaire",
                    partner_cancelation: "Annulation partenaire",
                    partner_confirmation: "Confirmation partenaire",
                    option: "Option",
                    // est-ce que les libelles option_cancelation et option_request sont corrects ?
                    option_cancelation: "Annulation option",
                    option_request: "Demande option",
                },

                colorStatus: {
                    request: "blue",
                    cancelled: "pink",
                    reserved: "red",
                    multiple: "yellow",

                    request_without_followup: "blue",

                    confirmation: "red",
                    cancelation: "pink",

                    partner_option: "orange",
                    partner_options: "orange",
                    partner_cancelation: "pink",
                    partner_confirmation: "black",

                    option: "green",
                    option_request: "blue",
                    option_cancellation: "pink",
                },

                abort_controller: undefined,
                initialLoadingCompleted: false,
            };
        },
        mounted() {
            // Loading filters
            this.sgFilterSearch = localStorage.sgFilterSearch ?? "";
            this.spacesFilter =
                localStorage.spacesFilter && localStorage.spacesFilter !== ""
                    ? JSON.parse(localStorage.spacesFilter)
                    : [];
            this.cityFilter = localStorage.cityFilter ?? "";
            this.zipFilter = localStorage.zipFilter ?? "";
            this.getWeeksByMonthAndYear(true);
            // Loading calendars
            axios.get("/api/calendars").then((res) => {
                this.agendas = res.data.data;

                this.availableCities = this.agendas
                    .map((e) => e.space_group && e.space_group.city ? e.space_group.city.replace(/((\s*\S+)*)\s*/, "$1") : null)
                    .filter((x, i, a) => x && a.indexOf(x) === i);

                this.availableZips = this.agendas
                    .map((e) => e.space_group && e.space_group.zip_code ? e.space_group.zip_code.replace(/((\s*\S+)*)\s*/, "$1") : null)
                    .filter((x, i, a) => x && a.indexOf(x) === i);

                this.availableSpaceGroups = this.agendas
                    .map((e) => e.space_group && e.space_group.name ? e.space_group.name.replace(/((\s*\S+)*)\s*/, "$1") : null)
                    .filter((x, i, a) => x && a.indexOf(x) === i);

                this.capacities = Object.fromEntries(
                    this.agendas
                        .map((agenda) => [
                            agenda.id,
                            agenda.tags.map(
                                (tag) =>
                                    +JSON.parse(tag.pivot.details)?.capacity ?? 0
                            ),
                        ])
                        .map(([id, capacities]) => {
                            capacities = capacities.filter(
                                (e, i, a) =>
                                    isFinite(e) &&
                                    e !== Infinity &&
                                    a.indexOf(e) === i &&
                                    0 < e
                            );
                            return [
                                id,
                                capacities.length > 0
                                    ? 1 < capacities.length
                                    ? [
                                        Math.min(...capacities),
                                        Math.max(...capacities),
                                    ]
                                    : 1 < capacities[0]
                                        ? [1, ...capacities]
                                        : []
                                    : [],
                            ];
                        })
                );
                this.reloadCalendars();
            });
        },
        methods: {
            closeAgendaElementsModal() {
                this.displayAddElementModal = !this.displayAddElementModal;
                this.reloadCalendars();
            },
            elementOnClick(agenda, index, status, time) {
                if (status === "none") {
                    this.newElementSelectedDate = "20" + index;
                    this.addElement(agenda.id, time);
                } else window.location = `/calendar/${agenda.id}/date/${index}`;
            },
            addElement(agendaId, time) {
                this.addElementAgendaId = agendaId;
                this.selectedTime = time;
                this.displayAddElementModal = true;
            },

            create_tooltip_element(cellLink) {

                const cell = cellLink.closest("td");
                if (!cell) throw new Error("cellLink is not in a td");
                const tooltip = document.createElement("div");
                const attributes = {
                    aria: {
                        hidden: "true",
                        live: "assertive",
                        atomic: "true",
                        relevant: "additions",
                    },
                    class: "tooltip",
                };

                // add css variable --x with value "calc(50% + 48px)"
                let xPos = cellLink.getBoundingClientRect().x;
                if(xPos < 800) {
                    tooltip.style.setProperty("left", "48px");
                } else {
                    tooltip.style.setProperty("--x", "calc(50% + 48px)");
                }
                tooltip.style.zIndex = "9999";
                for (let key in attributes) {
                    if ("object" === typeof attributes[key]) {
                        for (let subKey in attributes[key]) {
                            tooltip.setAttribute(
                                `${key}-${subKey}`,
                                attributes[key][subKey]
                            );
                        }
                        continue;
                    }
                    tooltip.setAttribute(key, attributes[key]);
                }
                tooltip.style.right = "var(--x)";
                let timeout_mouseenter = null;
                let timeout_mouseleave = null;
                cellLink.addEventListener(
                    "mouseenter",
                    (event) => {
                        const { target } = event;
                        if (timeout_mouseenter) {
                            clearTimeout(timeout_mouseenter);
                        }
                        timeout_mouseenter = setTimeout(() => {
                            let data_elements = JSON.parse(
                                target.getAttribute("data-elements") ?? "[]"
                            );

                            if (
                                typeof data_elements === "object" &&
                                !Array.isArray(data_elements)
                            ) {
                                data_elements = Object.keys(data_elements).map(
                                    (key) => data_elements[key]
                                );
                            }
                            if (1 > data_elements.length) return;
                            for (let i = 0; i < data_elements.length; i++) {
                                const {
                                    id,
                                    start,
                                    end,
                                    agenda_id,
                                    estimate_id,
                                    booking_id,
                                    status,
                                    name,
                                } = data_elements[i];
                                const element_status = ((status) => {
                                    const html = `<div class="tooltip-status bg-${this.colorStatus[status]}">${this.status[status]}</div>`;
                                    const template =
                                        document.createElement("template");
                                    template.innerHTML = html;
                                    return template.content.firstElementChild.cloneNode(
                                        true
                                    );
                                })(status);
                                const element_name = ((name) => {
                                    const html = `<span class="tooltip-name">${name}</div>`;
                                    const template =
                                        document.createElement("template");
                                    template.innerHTML = html;
                                    return template.content.firstElementChild.cloneNode(
                                        true
                                    );
                                })(name);
                                const date_start = start
                                    ? new Date(start)
                                    : undefined;
                                const date_end = end ? new Date(end) : undefined;
                                const is_start_invalid = isNaN(
                                    date_start.getTime()
                                );
                                const is_end_invalid = isNaN(date_end.getTime());
                                let element_date_hours, element_date_days;
                                if (!is_start_invalid) {
                                    const content_hours = [],
                                        content_days = [];
                                    if (date_start.getHours() !== 0) {
                                        content_hours.push(
                                            this.formatDateHour(date_start)
                                        );
                                    }
                                    content_days.push(
                                        this.formatDateDay(date_start)
                                    );
                                    if (
                                        date_start.getDate() !==
                                        date_end.getDate() &&
                                        !is_end_invalid
                                    ) {
                                        if (
                                            date_start.getHours() !==
                                            date_end.getHours()
                                        ) {
                                            content_hours.push(
                                                this.formatDateHour(date_end)
                                            );
                                        }
                                        content_days.push(
                                            this.formatDateDay(date_end)
                                        );
                                    }
                                    element_date_hours = !content_hours.length
                                        ? ((value) => {
                                            const html = `<span class="tooltip-date-hours">${value}</div>`;
                                            const template =
                                                document.createElement(
                                                    "template"
                                                );
                                            template.innerHTML = html;
                                            return template.content.firstElementChild.cloneNode(
                                                true
                                            );
                                        })(content_hours.join(" - "))
                                        : undefined;
                                    element_date_days = content_days
                                        ? ((value) => {
                                            const html = `<span class="tooltip-date-days">${value}</div>`;
                                            const template =
                                                document.createElement(
                                                    "template"
                                                );
                                            template.innerHTML = html;
                                            return template.content.firstElementChild.cloneNode(
                                                true
                                            );
                                        })(content_days.join(" - "))
                                        : undefined;
                                }
                                [
                                    element_status,
                                    element_name,
                                    element_date_hours,
                                    element_date_days,
                                ]
                                    .filter(Boolean)
                                    .forEach((element) => {
                                        tooltip.appendChild(element);
                                    });
                            }
                            if (tooltip.childElementCount > 0) {
                                target.appendChild(tooltip);
                            }
                            const { width: tooltipWidth } =
                                tooltip.getBoundingClientRect();
                            const { left: cellLinkLeft } =
                                cellLink.getBoundingClientRect();

                            if (cellLinkLeft < tooltipWidth * 1.45) {
                                setTimeout(() => {
                                    tooltip.style.right = "unset";
                                    tooltip.style.left = "var(--x)";
                                }, 0);
                            }
                            setTimeout(() => {
                                tooltip.style.opacity = "1";
                                tooltip.style.zIndex = "9999";
                                tooltip.style.visibility = "visible";
                            }, 0);
                        });
                    },
                    0
                );
                cellLink.addEventListener("mouseleave", (event) => {
                    const { target } = event;
                    if (timeout_mouseleave) {
                        clearTimeout(timeout_mouseleave);
                    }
                    timeout_mouseleave = setTimeout(() => {
                        tooltip.innerHTML = "";
                        tooltip.style.opacity = "0";
                        tooltip.style.zIndex = "-1";
                        tooltip.style.visibility = "hidden";
                        tooltip.remove();
                    }, 0);
                });
                return tooltip;
            },
            reloadCalendars(startDate = null, endDate = null) {

                if(!startDate) {
                    startDate = this.startDate;
                }
                if(!endDate) {
                    endDate = this.endDate;
                }

                if (this.abort_controller) this.abort_controller.abort();
                if (0 < Object.keys(this.agendasContents).length)
                    this.agendasContents = {};
                if (0 < Object.keys(this.header).length) this.header = [];
                if (0 < Object.keys(this.months).length) this.months = [];
                this.abort_controller = new AbortController();
                let agendas_ids = this.filteredAgendas.map((e) => e.id);

                const agendas = agendas_ids.reduce((acc, cur, i) => {
                    if (i % this.byChunk === 0)
                        acc.push(agendas_ids.slice(i, i + this.byChunk));
                    return acc;
                }, []);

                // split agenda by two id
                let promises = [];
                for (let currentAgenda of agendas) {
                    // get all week start and end date from startDate and EndDate

                    for(let agendaSplit of currentAgenda) {

                        const promise = axios
                            .get(
                                `/api/calendars/retrieve?start=${startDate}&end=${
                                    endDate
                                    }&calendars=${agendaSplit}`,
                                { signal: this.abort_controller.signal }
                            )
                            .then((res) => {
                                this.header = res.data.data.header;
                                this.firstSaturdayIndex = Math.min(
                                    this.header.findIndex((e) => e.day === "dim"),
                                    this.header.findIndex((e) => e.day === "sam") - 1
                                );
                                this.months = this.header
                                    .map((e) => e.month)
                                    .reduce(function (acc, curr) {
                                        return (
                                            acc[curr] ? ++acc[curr] : (acc[curr] = 1),
                                                acc
                                        );
                                    }, {});
                                Object.assign(
                                    this.agendasContents,
                                    res.data.data.agendas
                                );
                            })
                            .catch((err) => {
                                console.error(err);
                            });
                        promises.push(promise);
                    }
                }

                function onSuccess() {
                    const cellLinks = document.querySelectorAll(
                        '.tooltip-cell[aria-busy="true"]'
                    );
                    for (let cellLink of cellLinks) {
                        this.create_tooltip_element(cellLink);
                        cellLink.setAttribute("aria-busy", "false");
                    }
                    this.initialLoadingCompleted = true;
                }

                onSuccess = onSuccess.bind(this);

                for (let i = 0; i < promises.length; i++) {
                    const promise = promises[i];
                    promise
                        .then(() => {
                            onSuccess();
                        })
                        .catch((err) => {
                            let limit = 5,
                                done = false;
                            while (0 < limit-- && !done) {
                                promise
                                    .then(() => {
                                        onSuccess();
                                        done = true;
                                    })
                                    .catch((err) => {
                                        console.error(err);
                                    });
                            }
                        });
                }

                Promise.all(promises)
                    .then(() => {
                        onSuccess();
                    })
                    .catch((err) => {});
            },
            isWeekEnd(index) {
                return (
                    this.header[index].day === "dim" ||
                    this.header[index].day === "sam"
                );
            },
            formatDateHour(date) {
                return date.toLocaleTimeString("fr-FR", {
                    hour: "2-digit",
                    minute: "2-digit",
                });
            },
            formatDateDay(date) {
                return date.toLocaleDateString("fr-FR", {
                    weekday: "short",
                    day: "2-digit",
                    month: "short",
                });
            },
            getWeeksByMonthAndYear(reload) {

                // get all weeks date from month and yeaer
                const month =
                    localStorage.monthFilter ??
                        this.month2digits(new Date().getMonth() + 1);
                const year = localStorage.yearFilter ?? new Date().getFullYear();
                const weekSelected = localStorage.weekSelected ?? 0;
                const firstDayOfMonth = moment(`${year}-${month}`, "YYYY-MM-DD");
                const numOfDays = firstDayOfMonth.daysInMonth();
                let weeks = new Set();

                for (let i = 0; i < numOfDays; i++) {
                    const currentDay = moment(firstDayOfMonth, "YYYY-MM-DD").add(
                        i,
                        "days"
                    );

                    weeks.add(currentDay.isoWeek());
                }
                const weeksArray = Array.from(weeks);
                const weeksFinal = [];
                // get start date and end date from week number
                for (let i = 0; i < weeksArray.length; i++) {
                    const currentWeek = weeksArray[i];
                    const currentWeekStartDate = moment(
                        `${year}-W${currentWeek}-1`,
                        "YYYY-Www-d"
                    );
                    weeksFinal.push({
                        number: currentWeek,
                        startDate: currentWeekStartDate.format("YYYY-MM-DD"),
                        endDate: currentWeekStartDate
                            .add(6, "days")
                            .format("YYYY-MM-DD"),
                        readableStartDate: currentWeekStartDate
                            .subtract(6, "days")
                            .format("DD/MM"),
                        readableEndDate: currentWeekStartDate
                            .add(6, "days")
                            .format("DD/MM"),
                    });
                }
                this.weeks = weeksFinal;

                if(this.view === 'month') {
                    this.startDate = moment(`${year}-${month}`, "YYYY-MM-DD").format("YYYY-MM-DD");
                    this.endDate = moment(`${year}-${month}`, "YYYY-MM-DD").add(1, 'month').subtract(1, 'day').format("YYYY-MM-DD");

                    let mymonth = document.getElementById("agendaChangeMonth").value;
                    let myyear  = document.getElementById("agendaChangeYear").value;
                    let startDate = moment(myyear+"-"+mymonth, "YYYY-MM-DD").format("YYYY-MM-DD");
                    let endDate   = moment(myyear+"-"+mymonth, "YYYY-MM-DD").add(1, 'month').subtract(1, 'day').format("YYYY-MM-DD");

                    this.startDate = startDate;
                    this.endDate = endDate;

                    this.reloadCalendars(startDate, endDate);
                } else {
                    if (reload) {
                        const checkIfWeekSelected = weeksFinal.find(
                            (e) => e.number === parseInt(weekSelected)
                        );

                        if (checkIfWeekSelected) {
                            this.weekSelected = weekSelected;
                            this.startDate = checkIfWeekSelected.startDate;
                            this.endDate = checkIfWeekSelected.endDate;
                        } else {
                            this.weekSelected = weeksFinal[0].number;
                            this.startDate = weeksFinal[0].startDate;
                            this.endDate = weeksFinal[0].endDate;
                        }

                        this.reloadCalendars();

                    } else {
                        // get week number from start date and end date
                        const weekNumber = moment(
                            this.startDate,
                            "YYYY-MM-DD"
                        ).isoWeek();
                        this.weekSelected = weekNumber;

                    }
                }
            },
            weekChange() {
                const week = this.weeks.find((e) => e.number === this.weekSelected);
                this.startDate = moment(week.startDate).format("YYYY-MM-DD");
                this.endDate = moment(this.startDate)
                    .add(6, "days")
                    .format("YYYY-MM-DD");
                this.reloadCalendars();
            },
            next() {
                if(this.view === 'month') {
                    this.nextMonth();

                } else {
                    this.nextWeek();
                }
            },
            previous() {
                if(this.view === 'month') {
                    this.previousMonth();
                } else {
                    this.previousWeek();
                }
            },
            nextMonth() {

                this.startDate = moment(this.startDate).add(1, 'month').format("YYYY-MM-DD");
                this.endDate = moment(this.endDate).add(1, 'month').subtract(1, 'day').format("YYYY-MM-DD");
                this.month = moment(this.startDate).format("MM");
                this.year = moment(this.startDate).format("YYYY");

                let mymonth = document.getElementById("agendaChangeMonth").value;
                let myyear  = document.getElementById("agendaChangeYear").value;

                mymonth = parseInt(mymonth) + 1;

                if( mymonth == 13 ) {
                    myyear = parseInt(myyear) + 1;
                    mymonth = 1;
                }

                mymonth = this.month2digits(mymonth);

                let startDate = moment(myyear+"-"+mymonth, "YYYY-MM-DD").format("YYYY-MM-DD");
                let endDate   = moment(myyear+"-"+mymonth, "YYYY-MM-DD").add(1, 'month').subtract(1, 'day').format("YYYY-MM-DD");
                this.startDate = startDate;
                this.endDate = endDate;

                this.month = mymonth;
                this.year  = myyear;

                this.reloadCalendars(startDate, endDate);

            },
            previousMonth() {
                this.startDate = moment(this.startDate).subtract(1, 'month').format("YYYY-MM-DD");
                this.endDate = moment(this.endDate).subtract(1, 'month').add(1, 'day').format("YYYY-MM-DD");
                this.month = moment(this.startDate).format("MM");
                this.year = moment(this.startDate).format("YYYY");

                let mymonth = document.getElementById("agendaChangeMonth").value;
                let myyear  = document.getElementById("agendaChangeYear").value;

                mymonth = mymonth - 1;

                if( mymonth == 0 ) {
                    myyear = myyear - 1;
                    mymonth = 12;
                }

                mymonth = this.month2digits(mymonth);

                let startDate = moment(myyear+"-"+mymonth, "YYYY-MM-DD").format("YYYY-MM-DD");
                let endDate   = moment(myyear+"-"+mymonth, "YYYY-MM-DD").add(1, 'month').subtract(1, 'day').format("YYYY-MM-DD");
                this.startDate = startDate;
                this.endDate = endDate;

                this.month = mymonth;
                this.year  = myyear;

                this.reloadCalendars(startDate, endDate);
            },
            nextWeek() {
                // moment get next week
                const nextWeek = moment(this.startDate).add(7, "days");
                this.startDate = nextWeek.format("YYYY-MM-DD");
                this.endDate = nextWeek.add(6, "days").format("YYYY-MM-DD");
                this.month = nextWeek.format("MM");
                this.year = nextWeek.format("YYYY");
                this.getWeeksByMonthAndYear(false);
                this.reloadCalendars();
            },
            previousWeek() {
                const previousWeek = moment(this.startDate).subtract(7, "days");
                this.startDate = previousWeek.format("YYYY-MM-DD");
                this.endDate = previousWeek.add(6, "days").format("YYYY-MM-DD");
                this.month = previousWeek.format("MM");
                this.year = previousWeek.format("YYYY");
                this.getWeeksByMonthAndYear(false);
                this.reloadCalendars();
            },
            month2digits(month) {
                return (month < 10 ? "0" : "") + month;
            },
            formatForAPI(date) {
                var pad = function (num) {
                    return (num < 10 ? "0" : "") + num;
                };

                return (
                    date.getFullYear() +
                    "-" +
                    pad(date.getMonth() + 1) +
                    "-" +
                    pad(date.getDate())
                );
            },
            emptyFilters() {
                this.spacesFilter = [];
                this.cityFilter = "";
                this.zipFilter = "";
                this.sgFilterSearch = "";

                localStorage.spacesFilter = [];
                localStorage.cityFilter = "";
                localStorage.zipFilter = "";
                localStorage.sgFilterSearch = "";
            },
            emptySpaceFilter() {
                this.spacesFilter = [];
            },
            capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
        },
        computed: {
            filteredAgendas: function () {
                let agendas = this.agendas;

                if (this.spacesFilter.length > 0) {
                    agendas = agendas.filter((e) => {
                        const spaceGroupName = e.space_group && e.space_group.name ? e.space_group.name.replace(/((\s*\S+)*)\s*/, "$1") : null;
                        return spaceGroupName && this.spacesFilter.includes(spaceGroupName);
                    });
                }

                if (this.cityFilter !== "") {
                    agendas = agendas.filter((e) => {
                        const city = e.space_group && e.space_group.city ? e.space_group.city.replace(/((\s*\S+)*)\s*/, "$1") : null;
                        return city && this.cityFilter === city;
                    });
                }

                if (this.zipFilter !== "") {
                    agendas = agendas.filter((e) => {
                        const zipCode = e.space_group && e.space_group.zip_code ? e.space_group.zip_code.replace(/((\s*\S+)*)\s*/, "$1") : null;
                        return zipCode && this.zipFilter === zipCode;
                    });
                }

                return agendas;
            },
            filteredSpaceGroups: function () {
                return this.availableSpaceGroups.filter((e) =>
                    e.toLowerCase().includes(this.sgFilterSearch.toLowerCase())
                );
            },
        },
        watch: {
            spacesFilter(newSpacesFilter) {
                localStorage.spacesFilter = JSON.stringify(newSpacesFilter);
            },
            cityFilter(newCityFilter) {
                localStorage.cityFilter = newCityFilter;
            },
            zipFilter(newZipFilter) {
                localStorage.zipFilter = newZipFilter;
            },
            sgFilterSearch(newSgFilterSearch) {
                localStorage.sgFilterSearch = newSgFilterSearch;
            },
            month(newMonth) {
                localStorage.monthFilter = newMonth;
            },
            year(newYear) {
                localStorage.yearFilter = newYear;
            },
            weekSelected(newWeekSelected) {
                localStorage.weekSelected = newWeekSelected;
            },
            filteredAgendas(newFilteredAgendas) {
                // If we don't have the right data, reload it
                if (
                    this.initialLoadingCompleted &&
                    newFilteredAgendas.filter(
                        (e) => !this.agendasContents.hasOwnProperty(e.id)
                    ).length > 0
                ) {
                    this.reloadCalendars();
                }
            },
        },
    };
</script>
