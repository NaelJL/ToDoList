const editLogo = document.querySelectorAll('#edit_logo');
const edit = document.querySelectorAll('.edit');

editLogo.forEach((element, index) => {
    element.addEventListener('click', () => {
        edit.forEach((element, editIndex) => {
            if (index === editIndex) {
                if (element.style.display === 'none') {
                    element.style.display = 'block';
                } else {
                    element.style.display = 'none';
                }
            }
        })
    })
});