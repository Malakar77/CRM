document.addEventListener('DOMContentLoaded', (e)=>{


    document.getElementById('filterIcon').addEventListener('click', function (e) {

        let dropdownContent = document.getElementById('dropdownContent');

        dropdownContent.classList.toggle('show');

    });
})


