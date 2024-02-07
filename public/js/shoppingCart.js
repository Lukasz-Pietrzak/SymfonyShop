import { createButton } from "./Menu.js";

// Tworzymy element totalPriceButton
let totalPriceButton = document.createElement("span");

// Pobieramy element .total-price
let totalPriceCatcher = document.querySelector('.total-price');

// Parsujemy dane z dataset.price
let totalPrice = JSON.parse(totalPriceCatcher.dataset.price);

// Tworzymy przycisk i ustawiamy jego zawartość
createButton(totalPriceButton);
totalPriceButton.textContent = "Go to checkout: " + totalPrice + ' zł';

// Dodajemy element totalPriceButton do body
document.body.appendChild(totalPriceButton);

// Stylowanie, aby umieścić przycisk na dole strony
totalPriceButton.style.position = "fixed";
totalPriceButton.style.bottom = "0";
totalPriceButton.style.left = "50%";
totalPriceButton.style.transform = "translateX(-50%)";
totalPriceButton.style.width = "100%";

// Ustawiamy pozostałe style dla flexbox, aby przycisk był na środku
totalPriceButton.style.display = "flex";
totalPriceButton.style.justifyContent = "center";
