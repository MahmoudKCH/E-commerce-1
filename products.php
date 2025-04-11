<!DOCTYPE html>

<html lang="en">
    <head>
        <link href="assets/css/productStyle.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>

                

                // MENU BAR

                let menuBar = document.querySelector('#menu-bar');
                let menuPage = document.querySelector('#menu-page');
                let html = document.querySelector('html');

                // Determine Screen Device: Desktop or Mobile
                let menuBarStyle = window.getComputedStyle(menuBar);
                let screenType = '';

                if (menuBarStyle.display === "flex") {
                    screenType = "mobile"
                }
                else if (menuBarStyle.display === "none") {
                    screenType = "desktop"
                }
                else {
                    console.log("Error: Failed to identify screen type", screenType)
                }

                // Show/Hide Menu Page

                menuBar.addEventListener('click', () => {
                    menuPage.classList.toggle('active');

                    html.style.overflow = (menuPage.classList.contains('active')) ? "hidden" : "scroll"
                    navScroll(menuPage.classList.contains('active'))
                })

                // PRODUCT CARDS DISPLAY

                let productContainerWidth = document.querySelector('.product-cards-container').offsetWidth;

                let rootStyles = getComputedStyle(html);
                let productCardWidth;
                let productCards;

                if (screenType === "desktop") {
                    productCardWidth = parseInt(rootStyles.getPropertyValue('--product-card-width').replace('px', ''));
                    productCardsPerRow = Math.floor(productContainerWidth / (productCardWidth + 5));
                }
                else if (screenType === "mobile") {
                    productCardsPerRow = (html.offsetWidth > 430) ? 3 : 2
                    productCardWidth = Math.floor((productContainerWidth / productCardsPerRow) - 10)
                }
                else {
                    console.log("Error: Failed to set productCardsPerRow & productCardWidth")
                }

                let marginSpacing = (productContainerWidth - (productCardsPerRow * productCardWidth)) / (productCardsPerRow - 1);
                let lastElement = productCardsPerRow - 1;
               
                let sectionLastElement = []
                let productSections = document.querySelectorAll('.product-section');
                productSections.forEach((section) => {
                    productCards = section.querySelectorAll('.product-card');
                   
                    for (let i = 0; i < productCardsPerRow; i++) {
                        productCards[i].classList.add('active');
   
                        if (i === lastElement) {
                            productCards[i].style.marginRight = '0px';
                        }
                        else {
                            productCards[i].style.marginRight = `${marginSpacing}px`;
                        }
                    }

                    sectionLastElement[section.id] = lastElement;
                })
   
                // ADDING ITEMS TO WISHLIST
   
                let wishListCount;
                let heartButtons = document.querySelectorAll('.heart-button');
   
                heartButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        button.classList.toggle('active');
                       
                        wishListCount = accessCounter('.wishlist-link span');
                        wishListCount.innerHTML = document.querySelectorAll('.heart-button.active').length;
                    })
                })
   
                // ADDING ITEMS TO CART
   
                let cartCount;
                let cartButtons = document.querySelectorAll('.product-card .blue-button');
               
                cartButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        button.classList.toggle('active');
                       
                        let buttonString = button.innerHTML.trim();
                        if (buttonString == "Add To Cart") {
                            button.innerHTML = "Remove"
                        }
                        else if (buttonString == "Remove") {
                            button.innerHTML = "Add To Cart"
                        }
                        else {
                            console.log("Error: Adding items to cart failed.", buttonString, button.parentElement);
                        }
                       
                        cartCount = accessCounter('.cart-link span');
                        cartCount.innerHTML = document.querySelectorAll('.product-card .blue-button.active').length;
                    })
                })

                function accessCounter(spanElement) {
                    if (screenType === 'desktop') {
                        return document.querySelector('#navbar-tools').querySelector(spanElement)
                    }
                    else if (screenType === 'mobile') {
                        return document.querySelector('#menu-tools').querySelector(spanElement)
                    }
                    else {
                        console.log("Error: accessCounter Function failed.")
                    }
                }

                // SLIDESHOW

                let slideshowButtons = document.querySelectorAll('.slideshow-button');
                slideshowButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        let slideshowSection = button.parentElement.dataset.slideshow;
                        let slideshowContainer = document.querySelector(`#product-section-${slideshowSection}`);
                        let productCards = slideshowContainer.querySelectorAll('.product-card');

                        let currentSection = `product-section-${slideshowSection}`;
                        if (button.classList.contains('prev-button')) {
                            if (sectionLastElement[currentSection] <= (productCardsPerRow - 1)) {
                                sectionLastElement[currentSection] = productCards.length - 1
                            }
                            else {
                                sectionLastElement[currentSection]--
                            }
                        }
                        else if (button.classList.contains('next-button')) {
                            if (sectionLastElement[currentSection] === (productCards.length - 1)) {
                                sectionLastElement[currentSection] = productCardsPerRow - 1;
                            }
                            else {
                                sectionLastElement[currentSection]++
                            }
                        }
                        else {
                            console.log("Slideshow: Error occurred");
                        }

                        for (let i = 0; i < productCards.length; i++) {
                            if ((i <= sectionLastElement[currentSection]) && (i >= (sectionLastElement[currentSection] - (productCardsPerRow - 1)))) {
                                productCards[i].classList.add('active');

                                if (i === sectionLastElement[currentSection]) {
                                    productCards[i].style.marginRight = '0px'
                                }
                                else {
                                    productCards[i].style.marginRight = `${marginSpacing}px`
                                }
                            }
                            else {
                                productCards[i].classList.remove('active');
                                productCards[i].style.marginRight = '0px'
                            }
                        }
                    })
                })
            })
        </script>
    </head>
    <body>

        <nav>
            <div id="navbar">
                <div id="navbar-logo">
                    <img src="images\AppLOGO1.png" width="110" height="90">
                </div>
                <div id="navbar-links">
                    <ul>
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="products.php">Products</a>
                        </li>
                        <li>
                            <a href="#">Services</a>
                        </li>
                        <li>
                            <a href="#">About</a>
                        </li>
                    </ul>
                    <button class="blue-button">
                        <a href="shp-now.php">Account</a>
                    </button>
                </div>
            </div>
        </nav>
        

        <!-- MAIN BODY -->
        <div id="product-page-body">
           
            <!-- TOP SECTION -->
            <div id="product-top-container">
                <div id="product-top-wrapper">
                    <div id="product-top-text-section">
                        <h1>Latest Trending</h1>
                        <h2> Wireless Headphones</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec semper diam nisl, a pharetra nibh scelerisque quis.
                            Ante ipsum vestibulum primis in faucibus orci luctuc et ultrices posuere.
                        </p>
                        <button class="blue-button">
                            Shop Now
                        </button>
                    </div>
                    <div id="product-top-image-section">
                        <img src="images/product-page/top-headphones.png" alt="Large Light Beige Headphones">
                    </div>
                </div>
            </div> <!-- END OF TOP SECTION -->

            <!-- PRODUCT CATEGORIES -->
             <div id="product-category-container">
                <div id="product-category-text">
                    <span class="blue-line"></span>
                    <span class="section-category-text">Categories</span>
                </div>
                <div id="product-category-wrapper">
                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/all.png" alt="Image Collection Containing All Categories">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                All
                            </span>
                            <span class="product-category-number">
                                60 items
                            </span>
                        </div>
                    </div>

                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/headphone.png" alt="Image Collection Containing Headphones">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Headphones
                            </span>
                            <span class="product-category-number">
                                12 items
                            </span>
                        </div>
                    </div>

                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/watch.png" alt="Image Collection Containing Smartwatch">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Smartwatch
                            </span>
                            <span class="product-category-number">
                                12 items
                            </span>
                        </div>
                    </div>

                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/phone.png" alt="Image Collection Containing Mobile">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Mobile
                            </span>
                            <span class="product-category-number">
                                12 items
                            </span>
                        </div>
                    </div>

                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/ipad.png" alt="Image Collection Containing Tablet">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Tablet
                            </span>
                            <span class="product-category-number">
                                12 items
                            </span>
                        </div>
                    </div>

                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/laptop.png" alt="Image Collection Containing Laptop">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Laptop
                            </span>
                            <span class="product-category-number">
                                12 items
                            </span>
                        </div>
                    </div>
                </div>
            </div> <!-- END OF PRODUCT CATEGORIES -->

            <!-- PRODUCT CARDS/SLIDESHOW -->

            <!-- "ALL" SECTION -->
            <div class="product-section" id="product-section-all">
                <div class="product-section-top-container">
                    <div class="section-category-container">
                        <div class="section-category-type">
                            <span class="blue-line"></span>
                            <span class="section-category-text">All Electronics</span>
                        </div>
                        <h1>Explore Best Sellers</h1>
                    </div>

                    <div class="slideshow-buttons-container top" data-slideshow="all">
                        <button class="slideshow-button prev-button">
                            <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="rgb(64, 64, 64)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                        <button class="slideshow-button next-button">
                            <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="rgb(64, 64, 64)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                    </div>

                </div>

                <div class="product-cards-container">
                    <ul>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/01.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Navy Headphones</h1>
                                <p>$87.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/laptop/03.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Turquoise Laptop</h1>
                                <p>$249.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/03.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Skyblue Phone</h1>
                                <p>$149.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/tablet/01.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Lead Tablet</h1>
                                <p>$120.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/06.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Golden Headphones</h1>
                                <p>$130.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/laptop/02.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Fire Laptop</h1>
                                <p>$219.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/01.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Sandy Phone</h1>
                                <p>$135.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/tablet/02.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Sandy Tablet</h1>
                                <p>$119.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/03.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Candy Headphones</h1>
                                <p>$88.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/laptop/11.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Coral Laptop</h1>
                                <p>$255.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/04.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Mauve Phone</h1>
                                <p>$189.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/tablet/03.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Lilac Tablet</h1>
                                <p>$135.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="slideshow-buttons-container bottom" data-slideshow="all">
                    <button class="slideshow-button prev-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="rgb(64, 64, 64)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button class="slideshow-button next-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="rgb(64, 64, 64)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                </div>
            </div> <!-- END OF "ALL" SECTION -->

            <!-- HEADPHONES SECTION -->
            <div class="product-section" id="product-section-headphones">
                <div class="product-section-top-container">
                    <div class="section-category-container">
                        <div class="section-category-type">
                            <span class="blue-line"></span>
                            <span class="section-category-text">Headphones</span>
                        </div>
                        <h1>Discover Our Headphones</h1>
                    </div>
                    <div class="slideshow-buttons-container top" data-slideshow="headphones">
                        <button class="slideshow-button prev-button">
                            <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                        <button class="slideshow-button next-button">
                            <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                    </div>
                </div>
               
                <div class="product-cards-container">
                    <ul>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/01.png" alt="Navy Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Navy Headphones</h1>
                                <p>$87.99</p>
                                <button class="blue-button">
                                    Add To Cart
                                </button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/02.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>White Headphones</h1>
                                <p>$109.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/03.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Candy Headphones</h1>
                                <p>$88.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/04.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Mauve Headphones</h1>
                                <p>$95.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/05.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Black Headphones</h1>
                                <p>$72.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/06.png" alt="Golden Headphones">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Golden Headphones</h1>
                                <p>$130.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/07.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Olive Headphones</h1>
                                <p>$110.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/08.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Sour Headphones</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/09.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Bubble Headphones</h1>
                                <p>$104.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/10.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Koala Headphones</h1>
                                <p>$79.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/11.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Blue Headphones</h1>
                                <p>$120.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/headphones/12.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Berry Headphones</h1>
                                <p>$68.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="slideshow-buttons-container bottom" data-slideshow="headphones">
                    <button class="slideshow-button prev-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button class="slideshow-button next-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                </div>
            </div> <!-- END OF HEADPHONES COLLECTION -->

            <!-- FIRST PROMOTION SECTION -->
             <div class="promotion-section">
                <div class="promo-image-container">
                    <img src="images/product-page/featured-categories/WATCH2.png" alt="Collection of Smartwatches">
                </div>
                <div class="promo-text-container">
                    <div class="promo-heading">
                        <span class="blue-line"></span>
                        <h1>New Collection</h1>
                    </div>
                    <h2>Explore The World of Advanced Handwear</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur elit adipiscing. Donec semper diam nisl,
                        a pharetra scelerisqu nibh quis. Ante ipsum vestibulum.
                    </p>
                    <button class="blue-button">
                        Shop Now
                    </button>
                </div>
             </div>
            <!-- END OF FIRST PROMOTION SECTION -->

            <!-- SMARTWATCH SECTION -->
            <div class="product-section" id="product-section-smartwatch">
                <div class="product-section-top-container">
                    <div class="section-category-container">
                        <div class="section-category-type">
                            <span class="blue-line"></span>
                            <span class="section-category-text">Smartwatch</span>
                        </div>
                        <h1>New Handwear Collection</h1>
                    </div>
                    <div class="slideshow-buttons-container top" data-slideshow="smartwatch">
                        <button class="slideshow-button prev-button">
                            <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                        <button class="slideshow-button next-button">
                            <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                    </div>
                </div>
                <div class="product-cards-container">
                    <ul>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/01.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Floss Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/02.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Water Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/03.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Peach Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/04.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>              
