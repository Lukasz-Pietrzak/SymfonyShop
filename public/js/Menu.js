import { createSizePriceFromDatabase } from './createSizePriceFromDatabase.js';
import { RadioEvent } from './RadioEvent.js';
import { addIngredient } from './addIngredient.js';
import { HowManyPizza } from './HowManyPizza.js';
export {createIngredientButton};
export {noSizeCheckedFunction};
export {addButtonPlus};
export {addButtonMinus};


const orderNowButton = document.getElementById("order-now");
const mainTextElement = document.getElementById("main-text");
const addToCartButtons = document.querySelectorAll(".add-to-cart");
const cartIconElement = document.getElementById("cartIcon");

let price = [0];
let howManyClickPizza = [0];
let priceSave = [0];

let productId;
let radioSave = [false];
let noSizeChecked;
let sizePriceCreator;
let Radio;
let IngredientClass;
let overlay = document.createElement("div");

if(orderNowButton){
    orderNowButton.addEventListener("click", function(){
        mainTextElement.scrollIntoView({ behavior: 'smooth' });
    });
    
}


function createIngredientButton(nazwa, textContent) {
   nazwa.id = "PlusElement"; 
   nazwa.textContent = textContent;
   nazwa.style.width = "80px";
   nazwa.style.backgroundColor = "crimson";
   nazwa.style.padding = "5px";
   nazwa.style.paddingRight = "18px";
   nazwa.style.paddingLeft = "18px";
   nazwa.style.borderRadius = "10px";
   nazwa.style.marginRight = "10px";
   nazwa.style.fontWeight = "bold";
   nazwa.style.cursor = "pointer";
   nazwa.style.color = "white";
}

function addButtonPlus(priceSave, option, price, howManyClickPizza ) {
    priceSave[0] += option;
    price[0] = priceSave[0] * (howManyClickPizza[0] + 1);
    addToCart.textContent = "Add to cart" + " " + price[0] + " zł";
 }

 function addButtonMinus(priceSave, option, price) {
    priceSave[0] -= option;
    price[0] = priceSave[0] * (howManyClickPizza[0] + 1);
    addToCart.textContent = "Add to cart" + " " + price[0] + " zł";
 }

let addToCart = document.createElement('div');
addToCart.textContent = "Add to Cart 0 zł";
let ingredientPrice = 0;


let sizes = ['Small', 'Medium', 'Large'];
let sizeCounter = 0;
let ingredientFuture = [];
let sizeCheck = 0;
let dataToDatabase = [];
let ingredientId;

let category = [];


let cartPanel;

addToCartButtons.forEach(function(button) {
    button.addEventListener("click", function () {
              // Tworzenie nowego elementu div dla panelu
    cartPanel = document.createElement("div");
      // Ustawienie wymiarów i stylu panelu
      cartPanel.style.width = "320px";
      cartPanel.style.height = "auto";
      cartPanel.style.backgroundColor = "white"; // Kolor tła panelu
      cartPanel.style.padding = "20px"; // Dodatkowe wewnętrzne marginesy dla zawartości
      cartPanel.classList.add("cart-panel");
   
      // Zaokrąglenie końcówek prostokąta
      cartPanel.style.borderRadius = "10px";
   
      // Dodanie szarych kresk między napisami
      let separator = createSeparator();

     let titleElement = document.createElement("strong");
      titleElement.textContent = 'Sizes';
      cartPanel.appendChild(titleElement);

productId = this.getAttribute("data-productid");
let smallPrice = parseInt(JSON.parse(this.getAttribute("data-small")), 10);
let mediumPrice = parseInt(JSON.parse(this.getAttribute("data-medium")), 10);
let largePrice = parseInt(JSON.parse(this.getAttribute("data-large")), 10);
   
Radio = new RadioEvent(      
    radioSave,
    price,
    priceSave, 
    sizeCheck, 
    addToCart, 
    cartPanel, 
    noSizeChecked, 
    howManyClickPizza);


    sizePriceCreator = new createSizePriceFromDatabase(Radio, [smallPrice, mediumPrice, largePrice], sizes, sizeCounter);
    let sizesLabel = sizePriceCreator.createSizePrice();

   
     cartPanel.appendChild(sizesLabel);
        cartPanel.appendChild(separator);
   
let ingredientCatchers = document.querySelectorAll('.js-ingredients');

let ingredientsByCategory = {};
ingredientCatchers.forEach(function(ingredientCatcher) {

    ingredientId = JSON.parse(ingredientCatcher.dataset.ingredientid);
    let ingredientName = JSON.parse(ingredientCatcher.dataset.ingredient);
    let ingredientPriceBrutto = JSON.parse(ingredientCatcher.dataset.pricebrutto);
    let ingredientPriceBruttoInteger = parseInt(ingredientPriceBrutto, 10);
    let ingredientCategory = JSON.parse(ingredientCatcher.dataset.category);

    // Assuming ingredientsByCategory is an object with categories as keys
    if (!ingredientsByCategory[ingredientCategory]) {
        ingredientsByCategory[ingredientCategory] = [];
    }

    ingredientsByCategory[ingredientCategory].push({
        id: ingredientId,
        name: ingredientName,
        price: ingredientPriceBruttoInteger
    });
});


// Now, loop through categories and display ingredients under each category
for (let category in ingredientsByCategory) {
    let categoryIngredients = ingredientsByCategory[category];

    let separator = createSeparator();
    let titleElement = document.createElement("strong");
    titleElement.textContent = category;
    cartPanel.appendChild(titleElement);

    for (let i = 0; i < categoryIngredients.length; i++) {
        let ingredient = categoryIngredients[i];
        ingredientFuture = [ingredient.name];
        ingredientId = [ingredient.id];
        
        IngredientClass = new addIngredient(
            price,
            priceSave,
            howManyClickPizza,
            dataToDatabase,
            addToCart
            );
        let sausagesLabel = IngredientClass.addIngredient([ingredient.price], ingredientFuture, ingredientId);

        cartPanel.appendChild(sausagesLabel);
    }

    cartPanel.appendChild(separator);
}

      // Tworzenie overlaya
   
      // Ustawienie stylu overlaya
      overlay.style.position = "fixed";
      overlay.style.top = "0";
      overlay.style.left = "0";
      overlay.style.width = "100%";
      overlay.style.height = "100%";
      overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)"; // Przezroczyste tło czarne
   
      // Ustawienie stylu dla wyśrodkowania panelu
      overlay.style.display = "flex";
      overlay.style.justifyContent = "center";
      overlay.style.alignItems = "center";
   
      let HowManyPizzaVariable = new HowManyPizza(
        radioSave,
        price,
        priceSave,
        howManyClickPizza,
        addToCart,
        cartPanel
      );

      HowManyPizzaVariable.HowManyPizzaFunction();

   addToCart.style.marginTop = "5%";
      addToCart.style.backgroundColor = 'crimson';
      addToCart.style.padding = '10px';
      addToCart.style.paddingLeft = '20px';
      addToCart.style.paddingRight = '20px';
      addToCart.style.color = 'white';
      addToCart.style.fontSize = '20px';
      addToCart.style.textAlign = 'center';
      addToCart.style.cursor = 'pointer';

      cartPanel.appendChild(addToCart);
      // Dodanie panelu do overlaya
      overlay.appendChild(cartPanel);
   
      // Dodanie overlaya do body
      document.body.appendChild(overlay);
   
      // Dodanie nasłuchiwacza zdarzeń do overlaya
      overlay.addEventListener("click", function (event) {
         // Sprawdzenie czy kliknięcie nastąpiło poza panelem
         if (!cartPanel.contains(event.target)) {
            // Usunięcie overlaya i przywórcenie zmiennych do początkowego stanu
            sizeCounter = 0;
            price = [0];
            sizeCheck = 0;
            priceSave = [0];
            radioSave = [false];
            howManyClickPizza = [0];
            dataToDatabase = [];
            addToCart.textContent = "Add to cart 0 zł";
            document.body.removeChild(overlay);
         }
      });
   
    });
  });

// Funkcja tworząca separator (szarą kreskę)
function createSeparator() {
   let separator = document.createElement("div");
   separator.style.height = "1px";
   separator.style.backgroundColor = "#ccc"; // Szary kolor
   separator.style.margin = "10px 0";
   return separator;
}


noSizeChecked = document.createElement("div");


function noSizeCheckedFunction(){
    noSizeChecked.textContent = "Please check size";
    noSizeChecked.style.color = "red";
    noSizeChecked.style.font = "20px";
    noSizeChecked.style.textAlign = "center";
    cartPanel.appendChild(noSizeChecked);
}


let cartIconCounter = parseInt(localStorage.getItem("cartIconCounter")) || 0;

if(cartIconCounter > 0){
    cartIconElement.innerHTML = cartIconCounter;
    cartIconElement.style.backgroundColor = "crimson";
}


addToCart.addEventListener("click", function () {
    if (radioSave[0] == false) {
        noSizeCheckedFunction();
    } else {
        //Adding icon for shopping cart
        cartIconCounter++;
        cartIconElement.innerHTML = cartIconCounter;
        cartIconElement.style.backgroundColor = "crimson";

        localStorage.setItem("cartIconCounter", cartIconCounter);

        fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ price: price[0], productId, howManyClickPizza: howManyClickPizza[0] + 1, dataToDatabase }), // Poprawiono ten fragment
        })
        .then(response => response.json())
        .then(data => {
            console.log('Odpowiedź od serwera:', data);
        })
        .catch(error => {
            console.error('Wystąpił błąd:', error);
        });

  
    }
});

