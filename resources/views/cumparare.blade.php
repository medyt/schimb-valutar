<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tranzacție de Cumpărare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Cumpărare Valută</h1>

        <form action="{{ route('tranzactii.buy') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control" id="tip_tranzactie" name="tip_tranzactie" value="cumparare">
            <div class="form-group">
                <label for="client_name">Nume și prenume client</label>
                <input type="text" class="form-control" id="client_name" name="client_name" required>
            </div>

            <div class="form-group">
                <label for="residency">Calitate/Tara</label>
                <select class="form-control" id="residency" name="residency" required>
                    <option value="Rezident">Rezident</option>
                    <option value="Nerezident">Nerezident</option>
                </select>
            </div>

            <div class="form-group">
                <label for="valuta_cumparata">Selectează Valuta</label>
                <select class="form-control valuta-select" name="valuta_cumparata[]" required>
                    @foreach ($rateSchimb as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-cumparare="{{ $rata->cumparare }}">{{ $rata->denumire_valuta }} - {{ $rata->cumparare }} RON</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="suma_vanduta">Suma dorită (în valuta selectată)</label>
                <input type="number" class="form-control suma-input" name="suma_vanduta[]" required min="5">
            </div>

            <div id="additional-currencies"></div>
            
            <button type="button" class="btn btn-link" id="add-currency">Adaugă altă valută</button>

            <div class="form-group">
                <label for="document">Tip document identitate</label>
                <select class="form-control" id="document" name="document" required>
                    <option value="CI">CI</option>
                    <option value="Pasaport">Pașaport</option>
                </select>
            </div>

            <!-- Seria documentului -->
            <div class="form-group">
                <label for="document_serie">Seria Documentului de Identitate</label>
                <input type="text" class="form-control" id="document_serie" name="document_serie" required>
            </div>

            <div class="form-group">
                <label for="document_number">Număr document</label>
                <input type="text" class="form-control" id="document_number" name="document_number" required>
            </div>

            <!-- Suma de plată (readonly) -->
            <div class="form-group">
                <label for="suma_primita">Suma de plată (RON)</label>
                <input type="text" class="form-control" id="suma_primita" name="suma_primita" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Finalizează Tranzacția</button>
        </form>
    </div>

    <!-- Script pentru adăugarea mai multor valute -->
    <script>
        document.getElementById('add-currency').addEventListener('click', function () {
            const additionalCurrencies = document.getElementById('additional-currencies');
            const rateSchimb = @json($rateSchimb);
            
            let select = '<div class="form-group">' +
                '<label for="valuta_cumparata">Selectează Valuta</label>' +
                '<select class="form-control valuta-select" name="valuta_cumparata[]" required>';
            
            rateSchimb.forEach(function (rata) {
                select += `<option value="${rata.valuta}" data-curs-cumparare="${rata.cumparare}">${rata.denumire_valuta} - ${rata.cumparare} RON</option>`;
            });
            
            select += '</select></div><div class="form-group">' +
                '<label for="suma_vanduta">Suma dorită (în valuta selectată)</label>' +
                '<input type="number" class="form-control suma-input" name="suma_vanduta[]" required min="5">' +
                '</div>';
            
            additionalCurrencies.insertAdjacentHTML('beforeend', select);

            // Reatașăm evenimentele pentru noile câmpuri adăugate
            reattachEventListeners();
        });

        // Reatașare evenimente pentru input-urile noi
        function reattachEventListeners() {
            const sumaInputs = document.querySelectorAll('.suma-input');
            const valutaSelects = document.querySelectorAll('.valuta-select');

            sumaInputs.forEach(input => input.addEventListener('input', calculateTotal));
            valutaSelects.forEach(select => select.addEventListener('change', calculateTotal));
        }

        // Script pentru calcularea sumei de plată
        function calculateTotal() {
            let total = 0;
            const sumaInputs = document.querySelectorAll('.suma-input');
            const valutaSelects = document.querySelectorAll('.valuta-select');

            // Adăugăm suma și cursul pentru câmpul inițial
            sumaInputs.forEach((input, index) => {
                const suma = parseFloat(input.value);
                const cursCumparare = parseFloat(valutaSelects[index].options[valutaSelects[index].selectedIndex].getAttribute('data-curs-cumparare'));

                if (!isNaN(suma) && !isNaN(cursCumparare)) {
                    total += suma * cursCumparare; // Adăugăm la total
                }
            });

            document.getElementById('suma_primita').value = total.toFixed(2) + ' RON'; // Afișăm suma totală
        }

        // Atașăm evenimentele inițiale
        reattachEventListeners();
    </script>
</body>
</html>
