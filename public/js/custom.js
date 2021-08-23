const user = document.getElementById('users_list');
user.addEventListener('click', e =>{
    if (e.target.className === 'btn btn-danger delete-user') {
        if (confirm('Are you sure?')) {
            const id = e.target.getAttribute('data-id');
            fetch('/users/delete/${id}',{
                method: 'DELETE'
            }).then(res => window.location.reload());
        } else {
            alert('Invalid Id');
        }
    }
});