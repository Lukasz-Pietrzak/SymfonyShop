import {addButtonPlus, addButtonMinus, createIngredientButton } from "./Menu.js";
export { addIngredient };

class addIngredient {
  constructor(price, priceSave, howManyClickPizza, dataToDatabase, addToCart) {
    this.price = price;
    this.priceSave = priceSave;
    this.howManyClickPizza = howManyClickPizza;
    this.dataToDatabase = dataToDatabase;
    this.addToCart = addToCart;
    this.label = document.createElement("div");
    this.label.style.margin = "10px 0";
    // Przycisk "+" i związane z nim elementy
    this.IngredientsButton = document.createElement("span");
    this.howManyIngredientsNumber = 0;
    this.numberIngredient = document.createElement("span");
    this.numberIngredient.style.marginRight = "12px";
    // Przycisk "-" i związane z nim elementy
    this.IngredientsButtonMinus = document.createElement("span");
    this.optionLabel = document.createElement("label");
    this.formCheck = document.createElement("div");
  }

  addIngredient(options, ingredientFuture, ingredientId) {
    options.forEach((option) => {
      // Obsługa zdarzenia po kliknięciu "+" (dodawanie)
      this.addIngredientEventPlus(option, ingredientId);

      // Obsługa zdarzenia po kliknięciu "-" (odejmowanie)
      this.addIngredientEventMinus(option, ingredientId);

      this.optionLabel.textContent = ingredientFuture[0] + " " + option + " zł";

      // Dodanie przycisków i etykiety do formCheck
      this.formCheck.appendChild(this.IngredientsButton);
      this.formCheck.appendChild(this.optionLabel);

      // Dodanie formCheck do etykiety
      this.label.appendChild(this.formCheck);
    });

    return this.label;
  }

  addIngredientEventPlus(option, ingredientId) {
    createIngredientButton(this.IngredientsButton, "+");

    this.IngredientsButton.addEventListener("click", () => {
      this.howManyIngredientsNumber++;
      this.dataToDatabase.push(ingredientId[0]);

      addButtonPlus(this.priceSave, option,this.price,this.howManyClickPizza);

      if (this.howManyIngredientsNumber === 1) {
        this.formCheck.insertBefore(
          this.IngredientsButtonMinus,
          this.IngredientsButton
        );
        this.formCheck.insertBefore(
          this.numberIngredient,
          this.IngredientsButton
        );
      }

      this.numberIngredient.textContent = this.howManyIngredientsNumber;
    });
  }

  addIngredientEventMinus(option, ingredientId) {
    // Przycisk "-" i związane z nim elementy
    createIngredientButton(this.IngredientsButtonMinus, "-");
    this.IngredientsButtonMinus.addEventListener("click", (event) => {
      this.howManyIngredientsNumber = Math.max(
        0,
        this.howManyIngredientsNumber - 1
      );
      this.numberIngredient.textContent = this.howManyIngredientsNumber;
      const indexToRemove = this.dataToDatabase.indexOf(ingredientId[0]);
      this.dataToDatabase.splice(indexToRemove, 1);

      addButtonMinus(this.priceSave, option,this.price,this.howManyClickPizza);

      // Sprawdź, czy liczba składników wynosi 0, zanim usuniesz elementy
      if (this.howManyIngredientsNumber === 0) {
        this.formCheck.removeChild(this.IngredientsButtonMinus);
        this.formCheck.removeChild(this.numberIngredient);

        // Zatrzymaj propagację zdarzenia kliknięcia, aby nie docierało do overlaya
        event.stopPropagation();
      }
    });
  }
}
