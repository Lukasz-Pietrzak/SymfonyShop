import { addButtonPlus, addButtonMinus } from "./Menu.js";
export { RadioEvent };

class RadioEvent {
    constructor(radioSave, price, priceSave, sizeCheck, addToCart, cartPanel, noSizeChecked, howManyClickPizza) {
        this.radioSave = radioSave;
        this.price = price;
        this.priceSave = priceSave;
        this.sizeCheck = sizeCheck;
        this.addToCart = addToCart;
        this.cartPanel = cartPanel;
        this.noSizeChecked = noSizeChecked;
        this.howManyClickPizza= howManyClickPizza;
    }

    createElementEvent(radio, option) {
        if (radio.checked) {
            this.price[0] -= this.sizeCheck;
            this.priceSave[0] -= this.sizeCheck;
            this.sizeCheck = option;

            addButtonPlus(this.priceSave, option,this.price,this.howManyClickPizza);

            this.radioSave[0] = true;
            if (this.cartPanel.contains(this.noSizeChecked)) {
                this.cartPanel.removeChild(this.noSizeChecked);
            }
        } else {
            this.radioSave[0] = false;
            addButtonMinus(this.priceSave, option,this.price,this.howManyClickPizza);

            this.sizeCheck = 0;
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