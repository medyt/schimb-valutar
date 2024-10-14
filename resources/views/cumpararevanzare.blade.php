<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tranzacție de Vânzare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center">Vânzare si cumparare Valută</h1>

        <form action="{{ route('tranzactii.buysell') }}" method="POST">
            @csrf
            <input type="hidden" class="form-control" id="tip_tranzactie" name="tip_tranzactie" value="cumpvanz">
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

            <div id="additional-currencies">
                <div class="form-group">
                    <label for="suma_vanduta">Suma vanduta (in valuta selectata pentru vanzare)</label>
                    <input type="number" class="form-control" name="suma_vanduta[]" min="5" required>
                </div>

                <div class="form-group">
                    <label for="valuta_vanduta">Selectează Valuta pe care vrei sa o vinzi</label>
                    <select class="form-control" name="valuta_vanduta[]" required>
                        @foreach ($rateSchimb as $rata)
                            <option value="{{ $rata->valuta }}" data-curs-vanzare="{{ $rata->vanzare }}">{{ $rata->denumire_valuta }} - {{ $rata->vanzare }} RON</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="valuta_cumparata">Selectează Valuta pe care vrei să o cumperi</label>
                    <select class="form-control" name="valuta_cumparata[]" required>
                        @foreach ($rateSchimb as $rata)
                            <option value="{{ $rata->valuta }}" data-curs-cumparare="{{ $rata->cumparare }}">{{ $rata->denumire_valuta }} - {{ $rata->cumparare }} RON</option>
                        @endforeach
                    </select>
                </div>

                <!-- Suma primită (pentru fiecare valută) -->
                <div class="form-group">
                    <label for="suma_primita">Suma primită (în valuta selectata pentru cumparare)</label>
                    <input type="text" class="form-control suma_primita" name="suma_primita[]" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-link" id="add-currency">Adaugă altă actiune de vanzare cumparare valuta</button>

            <div class="form-group">
                <label for="document">Tip document identitate</label>
                <select class="form-control" id="document" name="document" required>
                    <option value="CI">CI</option>
                    <option value="Pasaport">Pașaport</option>
                </select>
            </div>

            <div class="form-group">
                <label for="document_serie">Seria Documentului de Identitate</label>
                <input type="text" class="form-control" id="document_serie" name="document_serie" required>
            </div>

            <div class="form-group">
                <label for="document_number">Număr document</label>
                <input type="text" class="form-control" id="document_number" name="document_number" required>
            </div>

            <button type="submit" class="btn btn-primary">Finalizează Tranzacția</button>
        </form>
    </div>

    <script>
        // Script pentru adăugarea mai multor acțiuni de tip vânzare-cumpărare
    document.getElementById('add-currency').addEventListener('click', function () {
        const additionalCurrencies = document.getElementById('additional-currencies');

        const select = `
            <div class="form-group">
                <label for="suma_vanduta">Suma vândută (în valuta selectată)</label>
                <input type="number" class="form-control" name="suma_vanduta[]" min="5" required>
            </div>
            
            <div class="form-group">
                <label for="valuta_vanduta">Selectează Valuta pe care o vinzi</label>
                <select class="form-control" name="valuta_vanduta[]" required>
                    @foreach ($rateSchimb as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-vanzare="{{ $rata->vanzare }}">{{ $rata->denumire_valuta }} - {{ $rata->vanzare }} RON</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="valuta_cumparata">Selectează Valuta pe care o cumperi</label>
                <select class="form-control" name="valuta_cumparata[]" required>
                    @foreach ($rateSchimb as $rata)
                        <option value="{{ $rata->valuta }}" data-curs-cumparare="{{ $rata->cumparare }}">{{ $rata->denumire_valuta }} - {{ $rata->cumparare }} RON</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="suma_primita">Suma primită (în valuta selectată pentru cumpărare)</label>
                <input type="text" class="form-control suma_primita" name="suma_primita[]" readonly>
            </div>
        `;

        additionalCurrencies.insertAdjacentHTML('beforeend', select);
    });

    // Script pentru calcularea sumei primite
    document.addEventListener('input', function() {
        calculateTotal();
    });

    function calculateTotal() {
        const sumaInputs = document.querySelectorAll('input[name="suma_vanduta[]"]');
        const valutaVandutaSelects = document.querySelectorAll('select[name="valuta_vanduta[]"]');
        const valutaCumparataSelects = document.querySelectorAll('select[name="valuta_cumparata[]"]');

        sumaInputs.forEach((input, index) => {
            const sumaVanduta = parseFloat(input.value);
            const valutaVanduta = valutaVandutaSelects[index];
            const valutaCumparata = valutaCumparataSelects[index];

            const cursVanzare = parseFloat(valutaVanduta.options[valutaVanduta.selectedIndex].getAttribute('data-curs-vanzare'));
            const cursCumparare = parseFloat(valutaCumparata.options[valutaCumparata.selectedIndex].getAttribute('data-curs-cumparare'));

            let sumaPrimita = 0;

            // Calculăm suma primită în valuta cumpărată folosind conversia valuta_vanduta -> RON -> valuta_cumparata
            if (!isNaN(sumaVanduta) && !isNaN(cursVanzare) && !isNaN(cursCumparare)) {
                const sumaInRON = sumaVanduta * cursVanzare; // Convertim în RON
                sumaPrimita = sumaInRON / cursCumparare;     // Convertim din RON în valuta cumpărată
            }

            // Afișăm suma primită în câmpul corespunzător
            const sumaPrimitaInput = document.querySelectorAll('.suma_primita')[index];
            sumaPrimitaInput.value = sumaPrimita.toFixed(2);
        });
    }

    </script>
</body>
</html>