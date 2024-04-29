# Terminal-pizza
terminal for accepting pizza orders. The front part will consist of 3 dropdowns and an “order” button. In dropdowns you can choose the type and size of pizza and sauce.
Pizzas: Pepperoni, Country, Hawaiian, Mushroom.
Size, cm: 21, 26, 31, 45.
Sauces: cheese, sweet and sour, garlic, barbecue
Prices can be taken arbitrarily. But, they should differ between types of pizza. And the larger the size, the higher the price should be. You can only order one pizza at a time.
After clicking the “order” button, a receipt with the order price and its description (what was selected in the dropdowns) should appear on the front.
Connected MySQL. Store and receive data about pizzas, sauces and prices from the database. Implemented basic protection against SQL injections.
prices for pizzas and sauces are stored in USD currency in the database, and displayed to the client in BYN at the current rate.
