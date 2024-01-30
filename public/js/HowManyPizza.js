import { noSizeCheckedFunction } from "./Menu.js";
import { createIngredientButton } from "./Menu.js";
export {HowManyPizza};

class HowManyPizza {
  constructor(radioSave, price, priceSave, howManyClickPizza, addToCart, cartPanel) {
    this.radioSave = radioSave;
    this.price = price;
    this.priceSave = priceSave;
    this.howManyClickPizza = howManyClickPizza;
    this.addToCart = addToCart;
    this.cartPanel = cartPanel;
    this.numberPizza = 1;
    this.howManyPizzaText = document.createElement("strong");
    this.howManyPizzaDiv = document.createElement("div");
    this.howManyPizzaButtonPlus = document.createElement("span");
    this.numberOfPizza = document.createElement("span");
    this.howManyPizzaButtonMinus = document.createElement("span");

  }

  HowManyPizzaFunction() {
    this.howManyPizzaText.textContent = "The number of pizza";

    this.howManyPizzaDiv.style.marginTop = "3%";

    createIngredientButton(this.howManyPizzaButtonPlus, "+");

    this.howManyPizzaButtonPlus.addEventListener("click", () => {
      if (this.radioSave[0] == false) {
        noSizeCheckedFunction();
      } else {
        this.numberPizza++;
        this.price[0] += this.priceSave[0];
        this.addToCart.textContent = "Add to cart" + " " + this.price[0] + " zł";
        this.numberOfPizza.textContent = this.numberPizza;
        this.howManyClickPizza[0]++;
      }
    });

    this.numberOfPizza.textContent = this.numberPizza;

    createIngredientButton(this.howManyPizzaButtonMinus, "-");

    this.howManyPizzaButtonMinus.addEventListener("click", () => {
      if (this.radioSave[0] == false) {
        noSizeCheckedFunction();
      } else {
        if (this.numberPizza >= 2) {
          this.numberPizza--;
          this.price[0] = this.priceSave[0] * this.howManyClickPizza[0];
          this.addToCart.textContent = "Add to cart" + " " + this.price[0] + " zł";
          if (this.howManyClickPizza[0] > 0) {
            this.howManyClickPizza[0]--;
          }
        }
        this.numberOfPizza.textContent = this.numberPizza;
      }
    });

    this.howManyPizzaButtonMinus.style.marginLeft = "4%";

    this.cartPanel.appendChild(this.howManyPizzaText);
    this.cartPanel.appendChild(this.howManyPizzaDiv);
    this.howManyPizzaDiv.appendChild(this.howManyPizzaButtonPlus);
    this.howManyPizzaDiv.appendChild(this.numberOfPizza);
    this.howManyPizzaDiv.appendChild(this.howManyPizzaButtonMinus);
  }
}
