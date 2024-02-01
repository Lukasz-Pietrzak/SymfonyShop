export { createSizePriceFromDatabase };

class createSizePriceFromDatabase {
    constructor(RadioEvent, options, sizes, sizeCounter) {
        this.RadioEvent = RadioEvent;
        this.options = options;
        this.sizes = sizes;
        this.sizeCounter = sizeCounter;
        this.label = document.createElement("div");
        this.label.style.margin = "10px 0";
    }

    createSizePrice() {
        this.options.forEach((option) => {
            let formCheck = document.createElement("div");
            formCheck.classList.add("form-check");

            let radio = document.createElement("input");
            radio.id = option;
            radio.type = "radio";
            radio.classList.add("form-check-input");
            radio.name = "options";
            radio.value = option;

            let optionLabel = document.createElement("label");


            optionLabel.classList.add("form-check-label");
            optionLabel.textContent = this.sizes[this.sizeCounter] + ' ' + option + " zł";

            this.RadioEvent.createRadioEvent(radio, option, this.sizes[this.sizeCounter]);

            formCheck.appendChild(radio);
            formCheck.appendChild(optionLabel);

            this.label.appendChild(formCheck);

            this.RadioEvent.createLabelEvent(optionLabel, radio, option,this.sizes[this.sizeCounter] );
            this.sizeCounter++;

        });

        return this.label;
    }
}


