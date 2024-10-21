<form action="{{ route('tranzactii.sell') }}" method="POST">
    @csrf
    <input type="hidden" class="form-control" id="tip_tranzactie" name="tip_tranzactie" value="vanzare">
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

    <div id="additional-currencies-vanzare">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="suma_vanduta_vanzare">Suma vanduta (in valuta selectata)</label>
                <input type="number" class="form-control suma-vanduta" name="suma_vanduta_vanzare[]" min="5" required>
            </div>

            <div class="form-group col-md-4">
                <label for="valuta_vanduta_vanzare">Selectează Valuta</label>
                <select class="form-control" name="valuta_vanduta_vanzare[]" required>
                    @foreach ($rate as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-vanzare="{{ $rata->vanzare }}">{{ $rata->denumire_valuta }} - {{ $rata->vanzare }} RON</option>
                    @endforeach
                </select>
            </div>

            <!-- Suma primită (pentru fiecare valută) -->
            <div class="form-group col-md-4">
                <label for="suma_primita_vanzare">Suma primită (în RON)</label>
                <input type="text" class="form-control suma_primita_vanzare" name="suma_primita_vanzare[]" readonly>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-link add-currency" id="add-currency-vanzare">Adaugă altă valută</button>

    <button type="submit" class="btn btn-primary" style="display:none">Finalizează Tranzacția</button>
</form>

<!-- Script pentru adăugarea mai multor valute -->
<script>
    document.getElementById('add-currency-vanzare').addEventListener('click', function () {
        const additionalCurrencies = document.getElementById('additional-currencies-vanzare');
        
        const select = `
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="suma_vanduta_vanzare">Suma vanduta (in valuta selectata)</label>
                    <input type="number" class="form-control suma-vanduta" name="suma_vanduta_vanzare[]" min="5" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="valuta_vanduta_vanzare">Selectează Valuta</label>
                    <select class="form-control" name="valuta_vanduta_vanzare[]" required>
                        @foreach ($rate as $rata)
                            <option value="{{ $rata->valuta }}" data-curs-vanzare="{{ $rata->vanzare }}">{{ $rata->denumire_valuta }} - {{ $rata->vanzare }} RON</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="suma_primita_vanzare">Suma primită (în valuta selectată)</label>
                    <input type="text" class="form-control suma_primita_vanzare" name="suma_primita_vanzare[]" readonly>
                </div>
            </div>
        `;

        additionalCurrencies.insertAdjacentHTML('beforeend', select);
    });
</script>

<!-- Script pentru calcularea sumei primite -->
<script>
    document.addEventListener('input', function() {
        if (event.target.classList.contains('suma-vanduta')) {
            culculateTotalVanzare();
        }
    });

    function culculateTotalVanzare() {
        const sumaInputs = document.querySelectorAll('input[name="suma_vanduta_vanzare[]"]');
        const valutaSelects = document.querySelectorAll('select[name="valuta_vanduta_vanzare[]"]');

        sumaInputs.forEach((input, index) => {
            const suma = parseFloat(input.value);
            const selectedValuta = valutaSelects[index];
            if(selectedValuta) {
                const cursVanzare = parseFloat(selectedValuta.options[selectedValuta.selectedIndex].getAttribute('data-curs-vanzare'));
                let sumaPrimita = 0;

                if (!isNaN(suma) && !isNaN(cursVanzare)) {
                    sumaPrimita = suma * cursVanzare; // Calculăm suma primită pentru fiecare valută
                }
                console.log(sumaPrimita);
                // Afișăm suma primită în câmpul corespunzător
                const sumaPrimitaInput = document.querySelectorAll('.suma_primita_vanzare')[index];
                sumaPrimitaInput.value = sumaPrimita.toFixed(2);
            }
        });
    }
</script>
