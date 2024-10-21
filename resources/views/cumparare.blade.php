<form action="{{ route('tranzactii.buy') }}" method="POST" class="cumparare-form">
    @csrf
    <input type="hidden" class="form-control" id="tip_tranzactie" name="tip_tranzactie" value="cumparare">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="client_name">Nume și prenume client</label>
            <input type="text" class="form-control" id="client_name" name="client_name" required>
        </div>

        <div class="form-group col-md-6">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="document">Tip</label>
                    <select class="form-control" id="document" name="document" required>
                        <option value="CI">CI</option>
                        <option value="Pasaport">Pașaport</option>
                    </select>
                </div>

                <!-- Seria documentului -->
                <div class="form-group col-md-4">
                    <label for="document_serie">Serie</label>
                    <input type="text" class="form-control" id="document_serie" name="document_serie" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="document_number">Număr</label>
                    <input type="text" class="form-control" id="document_number" name="document_number" required>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="form-group col-md-6">
            <label for="tara">Țara</label>
            <input type="text" class="form-control" id="tara" name="tara" required>
        </div>
        <div class="form-group col-md-6">
            <label for="residency">Calitate</label>
            <div class="row">
                <div class="form-check col-md-3">
                    <input class="form-check-input" type="radio" name="residency" id="rezident" value="Rezident" required>
                    <label class="form-check-label" for="rezident">
                        Rezident
                    </label>
                </div>
                <div class="form-check col-md-3">
                    <input class="form-check-input" type="radio" name="residency" id="nerezident" value="Nerezident" required>
                    <label class="form-check-label" for="nerezident">
                        Nerezident
                    </label>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="form-group col-md-6">
            <label for="valuta_cumparata">Selectează Valuta</label>
            <select class="form-control valuta-select" name="valuta_cumparata[]" required>
                @foreach ($rate as $rata)
                    <option value="{{ $rata->valuta }}" data-curs-cumparare="{{ $rata->cumparare }}">{{ $rata->denumire_valuta }} - {{ $rata->cumparare }} RON</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="suma_vanduta">Suma dorită (în valuta selectată)</label>
            <input type="number" class="form-control suma-input" name="suma_vanduta[]" required min="5">
        </div>
    </div>
    

    

    <div id="additional-currencies"></div>
    
    <button type="button" class="btn btn-link add-currency" id="add-currency-cumparare">Adaugă altă valută</button>

    <div class="row">
        <!-- Suma de plată (readonly) -->
        <div class="form-group col-md-6">
            <label for="suma_primita">Suma de plată (RON)</label>
            <input type="text" class="form-control" id="suma_primita" name="suma_primita" readonly>
        </div>
    </div>   

    <button type="submit" class="btn btn-primary" style="display:none">Finalizează Tranzacția</button>
</form>

<!-- Script pentru adăugarea mai multor valute -->
<script>
    const cumparareForm = document.querySelector('.cumparare-form');

    document.getElementById('add-currency-cumparare').addEventListener('click', function () {
        const additionalCurrencies = document.getElementById('additional-currencies');
        const rate = @json($rate);
        
        let select = '<div class="row"><div class="form-group col-md-6">' +
            '<label for="valuta_cumparata">Selectează Valuta</label>' +
            '<select class="form-control valuta-select" name="valuta_cumparata[]" required>';
        
        rate.forEach(function (rata) {
            select += `<option value="${rata.valuta}" data-curs-cumparare="${rata.cumparare}">${rata.denumire_valuta} - ${rata.cumparare} RON</option>`;
        });
        
        select += '</select></div><div class="form-group col-md-6">' +
            '<label for="suma_vanduta">Suma dorită (în valuta selectată)</label>' +
            '<input type="number" class="form-control suma-input" name="suma_vanduta[]" required min="5">' +
            '</div></div>';
        
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

    cumparareForm.addEventListener('input', function(event) {
        if (event.target.classList.contains('suma-input') || event.target.classList.contains('valuta-select')) {
            calculateTotal();
        }
    });
</script>
