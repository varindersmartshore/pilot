const user = document.getElementById('users_list');
if (user) {
    user.addEventListener('click', e =>{
        if (e.target.className === 'btn btn-danger delete-user') {
            if (confirm('Are you sure?')) {
                const id = parseInt(e.target.getAttribute('data-id'));
                if(id) {
                    fetch('/users/delete/'+id,{
                        method: 'GET'
                    }).then(res => window.location.reload());
                } else {
                    alert('No data id found');
                }
            } else {
                return false;
            }
        }
    });
}