let iconDeletes = document.querySelectorAll('.iconDelete');
let iconChecks = document.querySelectorAll('.iconCheck');

for(let i = 0; i < iconDeletes.length; i++) {
    iconDeletes[i].addEventListener('click', function(e) {
        deleteContact(this.dataset.id);
    })
}

for(let i = 0; i < iconChecks.length; i++) {
    iconChecks[i].addEventListener('click', function(e) {
        checkContact(this.dataset.id);
    })
}

const deleteContact = (contactId) => {


}



