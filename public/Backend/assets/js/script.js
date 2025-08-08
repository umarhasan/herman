const open = document.querySelector('#openbtn');
const close = document.querySelector('#closebtn');
const sidebar = document.querySelector('#sidebar');

open.addEventListener('click', () => {
    sidebar.classList.toggle('show')
})
close.addEventListener('click', () => {
    sidebar.classList.toggle('show')
})