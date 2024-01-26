export { RadioEvent };

class RadioEvent {
    constructor(radioSave, price, priceSave, sizeCheck, dataToDatabase, addToCart, cartPanel, noSizeChecked, howManyClickPizza) {
        this.radioSave = radioSave;
        this.price = price;
        this.priceSave = priceSave;
        this.sizeCheck = sizeCheck;
        this.dataToDatabase = dataToDatabase;
        this.addToCart = addToCart;
        this.cartPanel = cartPanel;
        this.noSizeChecked = noSizeChecked;
        this.howManyClickPizza = howManyClickPizza;
    }

    createElementEvent(radio, option) {
        if (radio.checked) {
            this.price -= this.sizeCheck;
            this.priceSave -= this.sizeCheck;
            this.sizeCheck = option;
            this.priceSave += option;
            this.price = this.priceSave * (this.howManyClickPizza + 1);
            this.radioSave = true;
            this.dataToDatabase.push(this.price);
            this.addToCart.textContent = "Add to cart" + ' ' + this.price + " zł";
            if (this.cartPanel.contains(this.noSizeChecked)) {
                this.cartPanel.removeChild(this.noSizeChecked);
            }
        } else {
            this.radioSave = false;
            this.priceSave -= option;
            this.price = this.priceSave * (this.howManyClickPizza + 1);
            this.sizeCheck = 0;
            this.addToCart.textContent = "Add to cart" + ' ' + this.price + " zł";
        }
    }

    createRadioEvent(radio, option) {
        radio.addEventListener("change", () => {
            this.createElementEvent(radio, option);
        });
    }

    createLabelEvent(optionLabel, radio, option) {
        optionLabel.addEventListener("click", () => {
            radio.checked = !radio.checked;
            this.createElementEvent(radio, option);
        });
    }
}