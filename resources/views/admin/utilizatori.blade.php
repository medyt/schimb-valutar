@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Lista Utilizatorilor</h1>

    <form method="GET" action="{{ route('utilizatori.index') }}" class="mb-4 row" style="display:none">
        <div class="form-group col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Caută utilizatori..." value="{{ request()->search }}">
        </div>
        <button type="submit" class="btn btn-primary col-md-6" style="max-height: 38px;">Caută direct in baza de date</button>
    </form>

    <table class="table table-striped table-bordered" id="utilizatoriTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($utilizatori as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editUser({{ $user }})" data-toggle="modal" data-target="#editUserModal">Editează</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $user->id }})">Șterge</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mb-3">
        <!-- Buton pentru a deschide modalul -->
        <button class="btn btn-success" data-toggle="modal" data-target="#addUserModal">Adaugă Utilizator</button>
    </div>
</div>

<!-- Modal pentru Editare Utilizator -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editează Utilizator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nume</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select class="form-control" id="edit_role" name="role" required>
                            <option value="1">Admin</option>
                            <option value="2">Patron</option>
                            <option value="3">Angajat</option>
                        </select>
                    </div>

                    <input type="hidden" id="user_id" name="user_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                <button type="button" class="btn btn-primary" id="saveUserBtn">Actualizează Utilizator</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pentru adăugarea utilizatorului -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Adaugă Utilizator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="addUserForm" action="{{ route('utilizatori.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nume</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="role">Rol</label>
                    <select name="role" class="form-control" required>
                        <option value="1">Admin</option>
                        <option value="2">Patron</option>
                        <option value="3">Angajat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Parolă</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmare Parolă</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary">Adaugă Utilizator</button>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables with options for better appearance
        $('#utilizatoriTable').DataTable({
            "language": {
                "lengthMenu": "Afișează _MENU_ utilizatori per pagină",
                "zeroRecords": "Nu au fost găsite rezultate",
                "info": "Afișare pagină _PAGE_ din _PAGES_",
                "infoEmpty": "Nu există utilizatori disponibili",
                "infoFiltered": "(filtrat din _MAX_ utilizatori total)",
                "search": "Caută:",
                "paginate": {
                    "next": "Următorul",
                    "previous": "Precedent"
                }
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Toți"]],
            "pageLength": 10
        });

        // Form submission for adding user
        $('#addUserForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    // Refresh the user table or update the table with new data
                    $('#addUserModal').modal('hide');
                    location.reload(); // Reload the page to see the new user
                },
                error: function(xhr) {
                    // Handle error (show error messages, etc.)
                    alert('Eroare: ' + xhr.responseText);
                }
            });
        });
    });

    function editUser(user) {
        // Umplem modalul cu datele utilizatorului
        $('#edit_name').val(user.name);
        $('#edit_email').val(user.email);
        $('#edit_role').val(user.role);
        $('#user_id').val(user.id);
    }

    $('#saveUserBtn').click(function() {
        // Obținem datele din formular
        var userId = $('#user_id').val();
        var formData = {
            name: $('#edit_name').val(),
            email: $('#edit_email').val(),
            role: $('#edit_role').val(),
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };

        $.ajax({
            url: '/admin/utilizatori/' + userId,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Reîncărcăm DataTable
                $('#userTable').DataTable().ajax.reload();
                $('#editUserModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('A apărut o eroare la actualizarea utilizatorului.');
            }
        });
    });

    function confirmDelete(userId) {
        if (confirm("Ești sigur că vrei să ștergi acest utilizator?")) {
            // Dacă utilizatorul confirmă, execută ștergerea
            deleteUser(userId);
        }
    }

    function deleteUser(userId) {
        $.ajax({
            url: '/admin/utilizatori/' + userId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // Poate dorești să actualizezi tabela sau să reîncărcați pagina
                alert(response.message);
                location.reload();
            },
            error: function(response) {
                alert("A apărut o eroare. Utilizatorul nu a fost șters.");
            }
        });
    }
</script>
@endsection
