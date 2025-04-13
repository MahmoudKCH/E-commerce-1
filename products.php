<!DOCTYPE html>

<html lang="en">
    <head>
       <link href="assets/css/productStyle.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            document.addEventListener('DOMContentLoaded', () => {   
      

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
            
                <div id="menu-bar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                </div>
            <div id="navbar">
                <div id="navbar-logo">
                    <img src="images\AppLOGO2.png" width="110" height="90">
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
        <!-- END OF MENU PAGE --> 

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
             <table>
             <div id="product-category-container">
                <div id="product-category-text">
                    <span class="blue-line"></span>
                    <span class="section-category-text">Categories</span>
                </div>
                

               <tr> <a href="#headphones"><td>
                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/headphone.png" alt="Image Collection Containing Headphones">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Headphones
                            </span>
                            <span class="product-category-number">
                                4 items
                            </span>
                        </div>
                    </div>
                </td></a>

                <td>

                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/watch.png" alt="Image Collection Containing Smartwatch">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Smartwatch
                            </span>
                            <span class="product-category-number">
                                4 items
                            </span>
                        </div>
                    </div>
                    </td>

                    <td>
                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/phone.png" alt="Image Collection Containing Mobile">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Mobile
                            </span>
                            <span class="product-category-number">
                                4 items
                            </span>
                        </div>
                    </div>
                    </td>
                    </tr>

                    <tr>
                    <td>
                    <div class="product-category">
                        <div class="product-category-image-section">
                            <img src="images/collection/ipad.png" alt="Image Collection Containing Tablet">
                        </div>
                        <div class="product-category-desc-section">
                            <span class="product-category-type">
                                Tablet
                            </span>
                            <span class="product-category-number">
                                3 items
                            </span>
                        </div>
                    </div>
                    </td>

               
                    </tr>
                </div>
            </div>
            </table>
            <!-- END OF PRODUCT CATEGORIES -->







            <!-- PRODUCT CARDS/SLIDESHOW -->



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
                    
                </div>
                
                <div class="product-cards-container">
                    <ul>
                       

                        
                        
                       
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
                   
                </div>
                <div class="product-cards-container">
                    <ul>
                       
                        
                  
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/04.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Bear Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/05.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Beige Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/06.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Creamy Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/smartwatch/07.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Navy Smartwatch</h1>
                                <p>$99.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                       
                       
                       
                    </ul>
                </div>

                <div class="slideshow-buttons-container bottom" data-slideshow="smartwatch">
                    <button class="slideshow-button prev-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button class="slideshow-button next-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                </div>
            </div> <!-- END OF SMARTWATCH COLLECTION -->

            <!-- MOBILE PHONE SECTION -->
            <div class="product-section" id="product-section-mobile">
                <div class="product-section-top-container">
                    <div class="section-category-container">
                        <div class="section-category-type">
                            <span class="blue-line"></span>
                            <span class="section-category-text">Mobile</span>
                        </div>
                        <h1>Discover Our Mobiles</h1>
                    </div>
                    
                </div>
                <div class="product-cards-container">
                    <ul>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/01.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Sandy Phone</h1>
                                <p>$135.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/02.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Candyfloss Phone</h1>
                                <p>$129.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/03.png" alt="Skyblue Phone">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Skyblue Phone</h1>
                                <p>$149.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/mobile/04.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Mauve Phone</h1>
                                <p>$189.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        

                  
                       
                    </ul>
                </div>

                <div class="slideshow-buttons-container bottom" data-slideshow="mobile">
                    <button class="slideshow-button prev-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button class="slideshow-button next-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                </div>
            </div> <!-- END OF MOBILE PHONES COLLECTION -->

          

            <!-- TABLET SECTION -->
            <div class="product-section" id="product-section-tablet">
                <div class="product-section-top-container">
                    <div class="section-category-container">
                        <div class="section-category-type">
                            <span class="blue-line"></span>
                            <span class="section-category-text">Tablet</span>
                        </div>
                        <h1>Explore Our Tablets</h1>
                    </div>
                    <div class="slideshow-buttons-container top" data-slideshow="tablet">
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
                                <img src="images/product-page/tablet/01.png" alt="Lead Tablet">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Lead Tablet</h1>
                                <p>$120.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/tablet/02.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Sandy Tablet</h1>
                                <p>$119.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                        <li class="product-card">
                            <div class="product-image-container">
                                <img src="images/product-page/tablet/03.png" alt="Product 1">
                                <button class="heart-button">
                                    <svg viewBox="0 0 24 24" width="22px" height="22px" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </div>
                            <div class="product-text-container">
                                <h1>Lilac Tablet</h1>
                                <p>$135.99</p>
                                <button class="blue-button">Add To Cart</button>
                            </div>
                        </li>
                       
                        
                    </ul>
                </div>

                <div class="slideshow-buttons-container bottom" data-slideshow="tablet">
                    <button class="slideshow-button prev-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M15 6L9 12L15 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                    <button class="slideshow-button next-button">
                        <svg viewBox="0 0 24 24" fill="none" width="30px" height="30px" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9 6L15 12L9 18" stroke="#414141" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                    </button>
                </div>
            </div> <!-- END OF TABLET COLLECTION -->

            

            <!-- END OF PRODUCT SECTIONS -->

        </div> <!-- END OF MAIN BODY -->
    </body>
    <footer>
        <div id="footer-top">
        <img src="images/AppLOGO2.png" width="200px" height="190px">
            <div id="footer-socials-wrapper">
                <div class="footer-social">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                    </svg>
                    <span>012 345 6789</span>
                </div>
                <div class="footer-social">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
                    </svg>
                    <a href="https://www.telegram.com">Telegram</a>
                </div>
                <div class="footer-social">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"/>
                    </svg>
                    <a href="https://www.twitter.com">Twitter</a>
                </div>
            </div>
            
        </div>
        <div id="footer-bottom">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <a href="products.html">Products</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
            </ul>
            <p>
                Copyright © 2024 SHOPini. All rights reserved.
            </p>
        </div>
    </footer>
</html>
<?php
require_once 'config.php';
$stmt = $db->query("SELECT * FROM produits");
$produits = $stmt->fetchAll();
?>

<!-- Remplacez le contenu statique par une boucle PHP -->
<ul class="product-section-items-wrapper">
    <?php foreach ($produits as $produit): ?>
    <li class="product-item">
        <div class="product-image">
            <img src="images/collection/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
        </div>
        <div class="product-text">
            <span class="product-title"><?= htmlspecialchars($produit['nom']) ?></span>
            <span class="product-price">$<?= htmlspecialchars($produit['prix']) ?></span>
            <button class="blue-button add-to-cart">Add To Cart</button>
        </div>
    </li>
    <?php endforeach; ?>
</ul>


