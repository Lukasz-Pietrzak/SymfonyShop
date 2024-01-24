const orderNowButton = document.getElementById("order-now");
const mainTextElement = document.getElementById("main-text");
const addToCartButtons = document.querySelectorAll(".add-to-cart");
const cartIconElement = document.getElementById("cartIcon");


let price = 0;
let productId;
let priceSave = [];
let radioSave = false;
let noSizeChecked;
let howManyClickPizza = 0;
// let productPrice = document.querySelector('.js-products-price');
// let smallPrice = parseInt(small, 10);
// let productId = this.dataset.productid;


orderNowButton.addEventListener("click", function(){
    mainTextElement.scrollIntoView({ behavior: 'smooth' });
});


function howManyIngredientsButton(nazwa, textContent) {
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


let addToCart = document.createElement('div');
addToCart.textContent = "Add to Cart 0 zł";
let ingredientPrice = 0;


let sizes = ['Small', 'Medium', 'Large'];
let sizeCounter = 0;
let ingredientFuture = [];
let sizeCheck = 0;
let dataToDatabase = [];

category = [];

let sizeFlag = false;

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

   
    let sizesLabel = createBootstrapLabel([smallPrice, mediumPrice, largePrice]);
   
     cartPanel.appendChild(sizesLabel);
        cartPanel.appendChild(separator);
   
let ingredientCatchers = document.querySelectorAll('.js-ingredients');

let ingredientsByCategory = {};
ingredientCatchers.forEach(function(ingredientCatcher) {
    let separator = createSeparator();

    let ingredientName = JSON.parse(ingredientCatcher.dataset.ingredient);
    let ingredientPriceBrutto = JSON.parse(ingredientCatcher.dataset.pricebrutto);
    let ingredientPriceBruttoInteger = parseInt(ingredientPriceBrutto, 10);
    let ingredientCategory = JSON.parse(ingredientCatcher.dataset.category);

    // Assuming ingredientsByCategory is an object with categories as keys
    if (!ingredientsByCategory[ingredientCategory]) {
        ingredientsByCategory[ingredientCategory] = [];
    }

    ingredientsByCategory[ingredientCategory].push({
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
        let sausagesLabel = addIngredient([ingredient.price]);
        cartPanel.appendChild(sausagesLabel);
    }

    cartPanel.appendChild(separator);
}

      // Tworzenie overlaya
      let overlay = document.createElement("div");
   
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
   
let numberPizza = 1;

      let howManyPizzaText = document.createElement("strong");
      howManyPizzaText.textContent = "The number of pizza";

      let howManyPizzaDiv = document.createElement("div");
      howManyPizzaDiv.style.marginTop = "3%";

      let howManyPizzaButtonPlus = document.createElement("span");
      howManyIngredientsButton(howManyPizzaButtonPlus, "+");

      howManyPizzaButtonPlus.addEventListener("click", function(){

        // if (radio.checked){
        //     addToCart.textContent = "dupa";
        // } 

        // TODO:
        numberPizza++;
        if (priceSave.length - 1 !== howManyClickPizza) {
            // Jeśli jest pusta, dodaj nową wartość jako pierwszy element
            priceSave.push(priceSave[howManyClickPizza - 1]);
        }        
        console.log(priceSave);

        price += priceSave[howManyClickPizza];
        addToCart.textContent = "Add to cart" + ' ' + price + ' zł';
        numberOfPizza.textContent = numberPizza;
        howManyClickPizza++;
      });


      let numberOfPizza = document.createElement("span");
      numberOfPizza.textContent = numberPizza;

      let howManyPizzaButtonMinus = document.createElement("span");
      howManyIngredientsButton(howManyPizzaButtonMinus, "-");


      howManyPizzaButtonMinus.addEventListener("click", function(){
        if(numberPizza >= 2){
            numberPizza--;
        //             if (priceSave.length - 1 !== howManyClickPizza) {
        //     // Jeśli jest pusta, dodaj nową wartość jako pierwszy element
        //     priceSave.push(priceSave[howManyClickPizza - 1]);
        // } 
            price -= priceSave[howManyClickPizza - 1];
            priceSave.pop();
        console.log(priceSave);
            addToCart.textContent = "Add to cart" + ' ' + price + ' zł';
            howManyClickPizza--;
        }
        numberOfPizza.textContent = numberPizza;
      });

      howManyPizzaButtonMinus.style.marginLeft = "4%";
      

   addToCart.style.marginTop = "5%";
      addToCart.style.backgroundColor = 'crimson';
      addToCart.style.padding = '10px';
      addToCart.style.paddingLeft = '20px';
      addToCart.style.paddingRight = '20px';
      addToCart.style.color = 'white';
      addToCart.style.fontSize = '20px';
      addToCart.style.textAlign = 'center';
      addToCart.style.cursor = 'pointer';

      cartPanel.appendChild(howManyPizzaText);
      cartPanel.appendChild(howManyPizzaDiv);
      howManyPizzaDiv.appendChild(howManyPizzaButtonPlus);
      howManyPizzaDiv.appendChild(numberOfPizza);
      howManyPizzaDiv.appendChild(howManyPizzaButtonMinus);
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
            price = 0;
            sizeCheck = 0;
            priceSave = [];
            howManyClickPizza = 0;
            sizeFlag = false;
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

// Funkcja tworząca napis z opcjami w Bootstrapie
function createBootstrapLabel(options) {
   let label = document.createElement("div");
   label.style.margin = "10px 0";

   options.forEach(function (option) {
      let formCheck = document.createElement("div");
      formCheck.classList.add("form-check");

    let radio = document.createElement("input");
    radio.type = "radio";
    radio.classList.add("form-check-input");
    radio.name = "options"; 
    radio.value = option; 

    radio.addEventListener("change", function() {
        if (radio.checked) {
            radioSave = true;
            price -= sizeCheck;
            // Sprawdź, czy tablica jest pusta
            if (priceSave.length - 1 !== howManyClickPizza) {
                // Jeśli jest pusta, dodaj nową wartość jako pierwszy element
                priceSave.push(0);
            }

            priceSave[howManyClickPizza] -= sizeCheck;
            sizeCheck = option;
                price += option;
                priceSave[howManyClickPizza] += option;
                dataToDatabase.push(price);
            addToCart.textContent = "Add to cart " + price + " zł";
            if (cartPanel.contains(noSizeChecked)){
                cartPanel.removeChild(noSizeChecked);
            }

        } else {
            radioSave = false;
            price -= option;
            priceSave[howManyClickPizza] -= option;
            sizeCheck = 0;
            addToCart.textContent = "Add to cart " + price + " zł";
        }
    });
    

      let optionLabel = document.createElement("label");
      optionLabel.classList.add("form-check-label");
      optionLabel.textContent = sizes[sizeCounter] + ' ' + option + " zł";
      sizeCounter++;

      // Dodanie checkboxa i etykiety do formCheck
      formCheck.appendChild(radio);
      formCheck.appendChild(optionLabel);

      // Dodanie formCheck do etykiety
      label.appendChild(formCheck);

      // Dodanie nasłuchiwania zdarzenia na etykietę
      optionLabel.addEventListener("click", function () {
         radio.checked = !radio.checked;
         if (radio.checked) {
            price -= sizeCheck;
            if (priceSave.length - 1 !== howManyClickPizza) {
                // Jeśli jest pusta, dodaj nową wartość jako pierwszy element
                priceSave.push(0);
            }
            // priceSave[howManyClickPizza] -= sizeCheck;
            sizeCheck = option;
                price += option;
                priceSave[howManyClickPizza] += option;
                radioSave = true;
      dataToDatabase.push(price);
            addToCart.textContent = "Add to cart" + ' ' + price + " zł";
            if (cartPanel.contains(noSizeChecked)){
                cartPanel.removeChild(noSizeChecked);
            }

        } else {
            radioSave = false;
            price -= option;
            priceSave[howManyClickPizza] -= option;
            sizeCheck = 0;
            addToCart.textContent = "Add to cart" + ' ' + price + " zł";
        }
      });
   });

   return label;
}

function addIngredient(options) {
   let label = document.createElement("div");
   label.style.margin = "10px 0";

   options.forEach(function (option) {
       let formCheck = document.createElement("div");

       // Przycisk "+" i związane z nim elementy
   let IngredientsButton = document.createElement("span");
//    let IngredientsButtonMinus = document.createElement("span");
//    let howManyIngredientsNumber = 0;
//    let numberIngredient = document.createElement("span");

//    createDynamicButton(IngredientsButton, IngredientsButtonMinus, howManyIngredientsNumber, numberIngredient);
       howManyIngredientsButton(IngredientsButton, "+");

       // Licznik ilości składników
       let howManyIngredientsNumber = 0;
       let numberIngredient = document.createElement("span");
       numberIngredient.style.marginRight = "12px";

       // Przycisk "-" i związane z nim elementy
       let IngredientsButtonMinus = document.createElement("span");
       howManyIngredientsButton(IngredientsButtonMinus, "-");

       // Obsługa zdarzenia po kliknięciu "+" (dodawanie)
       IngredientsButton.addEventListener("click", function() {
           howManyIngredientsNumber++;
           dataToDatabase.push(ingredientFuture[0]);

        price += option;
        if (priceSave.length - 1 !== howManyClickPizza) {
            // Jeśli jest pusta, dodaj nową wartość jako pierwszy element
            priceSave.push(0);
        }
        priceSave[howManyClickPizza] += option;
        addToCart.textContent = "Add to cart" + ' ' + price + " zł";

           if (howManyIngredientsNumber === 1) {
            formCheck.insertBefore(IngredientsButtonMinus, IngredientsButton);
            formCheck.insertBefore(numberIngredient, IngredientsButton);
           }

           numberIngredient.textContent = howManyIngredientsNumber;
       });

       // Obsługa zdarzenia po kliknięciu "-" (odejmowanie)
       IngredientsButtonMinus.addEventListener("click", function(event) {
         howManyIngredientsNumber = Math.max(0, howManyIngredientsNumber - 1);
         numberIngredient.textContent = howManyIngredientsNumber;

         price -= option;
         priceSave[howManyClickPizza] -= option;
         addToCart.textContent = "Add to cart" + ' ' + price + " zł";
     
         // Sprawdź, czy liczba składników wynosi 0, zanim usuniesz elementy
         if (howManyIngredientsNumber === 0) {
                 formCheck.removeChild(IngredientsButtonMinus);
                 formCheck.removeChild(numberIngredient);
             // Zatrzymaj propagację zdarzenia kliknięcia, aby nie docierało do overlaya
             event.stopPropagation();
         }
     });
     

       // Utworzenie etykiety składnika
       let optionLabel = document.createElement("label");
       optionLabel.textContent = ingredientFuture[0] + ' ' + option + " zł";

       // Dodanie przycisków i etykiety do formCheck
       formCheck.appendChild(IngredientsButton);
       formCheck.appendChild(optionLabel);

       // Dodanie formCheck do etykiety
       label.appendChild(formCheck);
   });

   return label;
}

let cartIconCounter = 1;


addToCart.addEventListener("click", function () {
    if (!radioSave) {
        noSizeChecked = document.createElement("div");
        noSizeChecked.textContent = "Please check size";
        noSizeChecked.style.color = "red";
        noSizeChecked.style.font = "20px";
        noSizeChecked.style.textAlign = "center";
        cartPanel.appendChild(noSizeChecked);
    } else {
        cartIconElement.innerHTML = cartIconCounter;
        cartIconElement.style.backgroundColor = "crimson";
        cartIconCounter++;
        // console.log(dataToDatabase);

        fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ price, productId }), // Shorthand property names
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

