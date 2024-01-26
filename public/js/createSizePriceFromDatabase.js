export { createSizePriceFromDatabase };

class createSizePriceFromDatabase {
    constructor(RadioEvent, options, sizes, sizeCounter, howManyClickPizza, price, sizeCheck, priceSave, dataToDatabase, cartPanel, addToCart, noSizeChecked, radioSave) {
        this.RadioEvent = RadioEvent;
        this.options = options;
        this.sizes = sizes;
        this.sizeCounter = sizeCounter;
        this.howManyClickPizza = howManyClickPizza;
        this.label = document.createElement("div");
        this.label.style.margin = "10px 0";
        this.price = price;
        this.sizeCheck = sizeCheck;
        this.priceSave = priceSave;
        this.dataToDatabase = dataToDatabase;
        this.cartPanel = cartPanel;
        this.addToCart = addToCart;
        this.noSizeChecked = noSizeChecked;
        this.radioSave = radioSave;
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

            this.RadioEvent.createRadioEvent(radio, option);

            optionLabel.classList.add("form-check-label");
            optionLabel.textContent = this.sizes[this.sizeCounter] + ' ' + option + " zł";
            this.sizeCounter++;

            formCheck.appendChild(radio);
            formCheck.appendChild(optionLabel);

            this.label.appendChild(formCheck);

            this.RadioEvent.createLabelEvent(optionLabel, radio, option);
        });

        return this.label;
    }
}


