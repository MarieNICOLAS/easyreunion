<template>
    <TransitionRoot
        :show="showModal"
        as="template"
    >
        <Dialog
            :open="showModal"
            as="div"
            class="fixed z-10 inset-0 overflow-y-auto"
            static
            @close="onClose"
        >
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed -z-10 inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
                </TransitionChild>
                <span
                    aria-hidden="true"
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                >&#8203;</span>
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div
                        class="inline-block align-bottom rounded-lg overflow-hidden shadow-xl transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full relative z-20"
                    >
                        <div
                            id="modal"
                            class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4"
                        >
                            <slot/>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
<script>
import {Dialog, DialogOverlay, TransitionChild, TransitionRoot} from "@headlessui/vue";

export default {
    name: "Modal",
    components: {
        Dialog,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
    },
    props: ['showModal', 'onClose']
}
</script>
