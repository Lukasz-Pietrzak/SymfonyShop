import { addButtonPlus, addButtonMinus } from "./Menu.js";
export { RadioEvent };

class RadioEvent {
    constructor(radioSave, price, priceSave, sizeCheck, addToCart, cartPanel, noSizeChecked, howManyClickPizza, sizeSave) {
        this.radioSave = radioSave;
        this.price = price;
        this.priceSave = priceSave;
        this.sizeCheck = sizeCheck;
        this.addToCart = addToCart;
        this.cartPanel = cartPanel;
        this.noSizeChecked = noSizeChecked;
        this.howManyClickPizza= howManyClickPizza;
        this.sizeSave = sizeSave;
    }

    createElementEvent(radio, option, size) {
        if (radio.checked) {
            this.price[0] -= this.sizeCheck;
            this.priceSave[0] -= this.sizeCheck;
            this.sizeCheck = option;
            this.sizeSave[0] = size;

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

    createRadioEvent(radio, option, size) {
        radio.addEventListener("change", () => {
            this.createElementEvent(radio, option, size);
        });
    }

    createLabelEvent(optionLabel, radio, option, size) {
        optionLabel.addEventListener("click", () => {
            radio.checked = !radio.checked;
            this.createElementEvent(radio, option, size);
        });
    }
}