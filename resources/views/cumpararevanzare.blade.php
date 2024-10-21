<form action="{{ route('tranzactii.buysell') }}" method="POST">
    @csrf
    <input type="hidden" class="form-control" id="tip_tranzactie" name="tip_tranzactie" value="cumpvanz">
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

    <div id="additional-currencies-cumpvanz">
        <div class="row">
            <div class="form-group col-md-3">
                <label for="suma_vanduta_cumpvanz">Suma vanduta (in valuta selectata pentru vanzare)</label>
                <input type="number" class="form-control" name="suma_vanduta_cumpvanz[]" min="5" required>
            </div>

            <div class="form-group col-md-3">
                <label for="valuta_vanduta_cumpvanz">Selectează Valuta pe care vrei sa o vinzi</label>
                <select class="form-control" name="valuta_vanduta_cumpvanz[]" required>
                    @foreach ($rate as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-vanzare="{{ $rata->vanzare }}">{{ $rata->denumire_valuta }} - {{ $rata->vanzare }} RON</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="valuta_cumparata_cumpvanz">Selectează Valuta pe care vrei să o cumperi</label>
                <select class="form-control" name="valuta_cumparata_cumpvanz[]" required>
                    @foreach ($rate as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-cumparare="{{ $rata->cumparare }}">{{ $rata->denumire_valuta }} - {{ $rata->cumparare }} RON</option>
                    @endforeach
                </select>
            </div>

            <!-- Suma primită (pentru fiecare valută) -->
            <div class="form-group col-md-3">
                <label for="suma_primita_cumpvanz">Suma primită (în valuta selectata pentru cumparare)</label>
                <input type="text" class="form-control suma_primita_cumpvanz" name="suma_primita_cumpvanz[]" readonly>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-link add-currency" id="add-currency-cumpvanz">Adaugă altă actiune de vanzare cumparare valuta</button>

    <button type="submit" class="btn btn-primary">Finalizează Tranzacția</button>
</form>

<script>
    // Script pentru adăugarea mai multor acțiuni de tip vânzare-cumpărare
    document.getElementById('add-currency-cumpvanz').addEventListener('click', function () {
        const additionalCurrencies = document.getElementById('additional-currencies-cumpvanz');

        const select = `
        <div class="row">
            <div class="form-group col-md-3">
                <label for="suma_vanduta_cumpvanz">Suma vândută (în valuta selectată pentru vanzare)</label>
                <input type="number" class="form-control" name="suma_vanduta_cumpvanz[]" min="5" required>
            </div>
            
            <div class="form-group col-md-3">
                <label for="valuta_vanduta_cumpvanz">Selectează Valuta pe care vrei sa o vinzi</label>
                <select class="form-control" name="valuta_vanduta_cumpvanz[]" required>
                    @foreach ($rate as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-vanzare="{{ $rata->vanzare }}">{{ $rata->denumire_valuta }} - {{ $rata->vanzare }} RON</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="valuta_cumparata_cumpvanz">Selectează Valuta pe care vrei sa o cumperi</label>
                <select class="form-control" name="valuta_cumparata_cumpvanz[]" required>
                    @foreach ($rate as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-cumparare="{{ $rata->cumparare }}">{{ $rata->denumire_valuta }} - {{ $rata->cumparare }} RON</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="suma_primita_cumpvanz">Suma primită (în valuta selectată pentru cumpărare)</label>
                <input type="text" class="form-control suma_primita_cumpvanz" name="suma_primita_cumpvanz[]" readonly>
            </div>
        </div>
        `;

        additionalCurrencies.insertAdjacentHTML('beforeend', select);
    });

    // Script pentru calcularea sumei primite
    document.addEventListener('input', function() {
        calculateTotalCumpVanz();
    });

    function calculateTotalCumpVanz() {
        const sumaInputs = document.querySelectorAll('input[name="suma_vanduta_cumpvanz[]"]');
        const valutaVandutaSelects = document.querySelectorAll('select[name="valuta_vanduta_cumpvanz[]"]');
        const valutaCumparataSelects = document.querySelectorAll('select[name="valuta_cumparata_cumpvanz[]"]');

        sumaInputs.forEach((input, index) => {
            const sumaVanduta = parseFloat(input.value);
            const valutaVanduta = valutaVandutaSelects[index];
            const valutaCumparata = valutaCumparataSelects[index];

            const cursVanzare = parseFloat(valutaVanduta.options[valutaVanduta.selectedIndex].getAttribute('data-curs-vanzare'));
            const cursCumparare = parseFloat(valutaCumparata.options[valutaCumparata.selectedIndex].getAttribute('data-curs-cumparare'));

            let sumaPrimita = 0;

            // Calculăm suma primită în valuta cumpărată folosind conversia valuta_vanduta_cumpvanz -> RON -> valuta_cumparata_cumpvanz
            if (!isNaN(sumaVanduta) && !isNaN(cursVanzare) && !isNaN(cursCumparare)) {
                const sumaInRON = sumaVanduta * cursVanzare; // Convertim în RON
                sumaPrimita = sumaInRON / cursCumparare;     // Convertim din RON în valuta cumpărată
            }

            // Afișăm suma primită în câmpul corespunzător
            const sumaPrimitaInput = document.querySelectorAll('.suma_primita_cumpvanz')[index];
            sumaPrimitaInput.value = sumaPrimita.toFixed(2);
        });
    }

</script>
