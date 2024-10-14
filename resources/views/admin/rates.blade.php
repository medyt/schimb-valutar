@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Administrare Rate de Schimb</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="ratesTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Valuta</th>
                <th>Denumire Valuta</th>
                <th>Oficial</th>
                <th>Cumpărare</th>
                <th>Vânzare</th>
                <th>Paritate</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rateSchimb as $rate)
                <tr>
                    <td>{{ $rate->id }}</td>
                    <td>{{ $rate->valuta }}</td>
                    <td>{{ $rate->denumire_valuta }}</td>
                    <td>{{ $rate->oficial }}</td>
                    <td>{{ $rate->cumparare }}</td>
                    <td>{{ $rate->vanzare }}</td>
                    <td>{{ $rate->paritate }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="{{ $rate->id }}"
                                data-valuta="{{ $rate->valuta }}"
                                data-denumire="{{ $rate->denumire_valuta }}"
                                data-oficial="{{ $rate->oficial }}"
                                data-cumparare="{{ $rate->cumparare }}"
                                data-vanzare="{{ $rate->vanzare }}"
                                data-paritate="{{ $rate->paritate }}">
                            Editează
                        </button>

                        <button class="btn btn-danger btn-sm delete-btn" 
                                data-id="{{ $rate->id }}" 
                                data-valuta="{{ $rate->valuta }}">
                            Șterge
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<button class="btn btn-primary mb-3" id="addRateBtn">Adaugă o Nouă Rată de Schimb</button>

<!-- Modal pentru adăugarea unei noi rate de schimb -->
<div class="modal fade" id="addRateModal" tabindex="-1" role="dialog" aria-labelledby="addRateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addRateForm" method="POST" action="{{ route('rates.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRateModalLabel">Adaugă o Nouă Rată de Schimb</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="valuta">Valuta</label>
                        <input type="text" class="form-control" id="valuta" name="valuta" required>
                    </div>

                    <div class="form-group">
                        <label for="denumire_valuta">Denumire Valuta</label>
                        <input type="text" class="form-control" id="denumire_valuta" name="denumire_valuta" required>
                    </div>

                    <div class="form-group">
                        <label for="oficial">Oficial</label>
                        <input type="number" step="0.0001" class="form-control" id="oficial" name="oficial" required>
                    </div>

                    <div class="form-group">
                        <label for="cumparare">Cumpărare</label>
                        <input type="number" step="0.0001" class="form-control" id="cumparare" name="cumparare" required>
                    </div>

                    <div class="form-group">
                        <label for="vanzare">Vânzare</label>
                        <input type="number" step="0.0001" class="form-control" id="vanzare" name="vanzare" required>
                    </div>

                    <div class="form-group">
                        <label for="paritate">Paritate</label>
                        <input type="number" step="0.0001" class="form-control" id="paritate" name="paritate" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                    <button type="submit" class="btn btn-primary">Adaugă Rata de Schimb</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal pentru editare -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editează Rata de Schimb</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="valuta">Valuta</label>
                        <input type="text" class="form-control" id="edit-valuta" name="valuta" required>
                    </div>

                    <div class="form-group">
                        <label for="denumire_valuta">Denumire Valuta</label>
                        <input type="text" class="form-control" id="edit-denumire" name="denumire_valuta" required>
                    </div>

                    <div class="form-group">
                        <label for="oficial">Oficial</label>
                        <input type="number" step="0.0001" class="form-control" id="edit-oficial" name="oficial" required>
                    </div>

                    <div class="form-group">
                        <label for="cumparare">Cumpărare</label>
                        <input type="number" step="0.0001" class="form-control" id="edit-cumparare" name="cumparare" required>
                    </div>

                    <div class="form-group">
                        <label for="vanzare">Vânzare</label>
                        <input type="number" step="0.0001" class="form-control" id="edit-vanzare" name="vanzare" required>
                    </div>

                    <div class="form-group">
                        <label for="paritate">Paritate</label>
                        <input type="number" step="0.0001" class="form-control" id="edit-paritate" name="paritate" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Închide</button>
                    <button type="submit" class="btn btn-primary">Salvează modificările</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal pentru ștergere -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmare Ștergere</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ești sigur că vrei să ștergi rata de schimb pentru valuta <span id="delete-valuta"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulează</button>
                    <button type="submit" class="btn btn-danger">Șterge</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inițializăm DataTable
        var table = $('#ratesTable').DataTable();

        // Editare cu AJAX
        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Previne trimiterea normală a formularului

            const formData = {
                valuta: $('#edit-valuta').val(),
                denumire_valuta: $('#edit-denumire').val(),
                oficial: $('#edit-oficial').val(),
                cumparare: $('#edit-cumparare').val(),
                vanzare: $('#edit-vanzare').val(),
                paritate: $('#edit-paritate').val(),
                _token: '{{ csrf_token() }}',
                _method: 'PUT'
            };

            const userId = $('#editForm').attr('action').split('/').pop(); // Extrage ID-ul din URL

            $.ajax({
                url: '/admin/rates/' + userId,
                type: 'POST',
                data: formData,
                success: function(response) {
                    location.reload();
                    $('#editModal').modal('hide');
                },
                error: function(xhr) {
                    alert('A apărut o eroare la actualizarea ratei de schimb.');
                }
            });
        });

        // Ștergere cu AJAX
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault(); // Previne trimiterea normală a formularului

            const userId = $('#deleteForm').attr('action').split('/').pop(); // Extrage ID-ul din URL

            $.ajax({
                url: '/admin/rates/' + userId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    location.reload();
                    $('#deleteModal').modal('hide');
                },
                error: function(xhr) {
                    alert('A apărut o eroare la ștergerea ratei de schimb.');
                }
            });
        });

        // Atașează evenimentele folosind event delegation pentru butoanele de editare și ștergere
        $('#ratesTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const valuta = $(this).data('valuta');
            const denumire = $(this).data('denumire');
            const oficial = $(this).data('oficial');
            const cumparare = $(this).data('cumparare');
            const vanzare = $(this).data('vanzare');
            const paritate = $(this).data('paritate');

            $('#edit-valuta').val(valuta);
            $('#edit-denumire').val(denumire);
            $('#edit-oficial').val(oficial);
            $('#edit-cumparare').val(cumparare);
            $('#edit-vanzare').val(vanzare);
            $('#edit-paritate').val(paritate);
            $('#editForm').attr('action', '/admin/rates/' + id);

            $('#editModal').modal('show');
        });

        $('#ratesTable').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const valuta = $(this).data('valuta');

            $('#delete-valuta').text(valuta);
            $('#deleteForm').attr('action', '/rates/' + id);

            $('#deleteModal').modal('show');
        });
    });
</script>
@endsection