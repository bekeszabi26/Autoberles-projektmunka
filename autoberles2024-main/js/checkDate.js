console.log("csatolva");
    // JavaScript kód a dátumok ellenőrzésére
    document.getElementById('startingDay').addEventListener('change', function () {
        let startingDay = new Date(this.value);
        let endingDayInput = document.getElementById('endingDay');

        // Ellenőrizzük, hogy a kiválasztott vége nap kisebb-e, mint a kezdeti nap
        if (endingDayInput.value) {
            let endingDay = new Date(endingDayInput.value);
            if (startingDay > endingDay) {
                alert('A "Foglalás vége" nem lehet korábbi, mint a "Foglalás kezdete".');
                endingDayInput.value = this.value;
            }
        }

        // Beállítjuk a minimum értéket a "Foglalás vége" inputnak
        endingDayInput.min = this.value;
    });

    document.getElementById('endingDay').addEventListener('change', function () {
        let endingDay = new Date(this.value);
        let startingDayInput = document.getElementById('startingDay');

        // Ellenőrizzük, hogy a kiválasztott kezdeti nap kisebb-e, mint a vége nap
        if (startingDayInput.value) {
            let startingDay = new Date(startingDayInput.value);
            if (endingDay < startingDay) {
                alert('A "Foglalás vége" nem lehet korábbi, mint a "Foglalás kezdete".');
                this.value = startingDayInput.value;
            }
        }

        // Beállítjuk a maximum értéket a "Foglalás kezdete" inputnak
        startingDayInput.max = this.value;
    });

