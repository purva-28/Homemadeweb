
//localStorage.clear()


async function displayAllProductsAjax(){
    const response = await fetch('products.json');
    const data = await response.json()
    return data
    //console.log(data)
}




let cartArray;

//cart icon
const cartIcon = document.querySelector('.cart-icon');

//localStorage.clear()
const nav = document.querySelector('.navbar');
const allProductsDiv = document.querySelector('.all-products');
const latestProductsDiv = document.querySelector('.latestproducts')
const productDetailsDiv = document.querySelector('.product-details-page')

//cart
const cartDiv = document.querySelector('.cart-content');
const cart = document.querySelector('.cart')
const cartOverlay = document.querySelector('.cart-overlay');
const closeBtn = document.querySelector('.close-cart')
const clearBtn = document.querySelector('.clear-cart');

//cart total
let cartTotal = document.querySelector('.cart-total');

let result = "";
let addtocart;


displayAllProductsAjax().then(data => {
    let display = data.map(function (item){
        let rating = ""
        for(let i=0; i< item.rating; i++){
            if (item.rating - i > 0.5) {
            rating += `<i class="fa fa-star"></i> \n`
            }
            else {
               rating += `<i class="fa fa-star-half-o"></i> \n`
            }
        }
        return `
        <div class="col-4" data-id = ${item.id}>
          <img src=${item.img} />
          <h4>${item.name}</h4>
          <div class="rating">
            ${rating} 
          </div>
          <p>Rs ${item.price}</p>
        </div>
        `

       
    })

    display = display.join("");
    latestProductsDiv.innerHTML = display

    
})


/* const displayAllProducts = () => {
    
    
} */


//displayAllProducts(allProducts,allProductsDiv);
//displayAllProducts(latestProducts,latestProductsDiv);

//local storage
 //local storage
const savelocalcart = (data) => {
    //let a=[];

        var a = [];
// Parse the serialized data back into an aray of objects
a = JSON.parse(localStorage.getItem('session')) || [];
// Push the new data (whether it be an object or anything else) onto the array
a.push(data);
// Alert the array value
alert(a);  // Should be something like [Object array]
// Re-serialize the array back into a string and store it in localStorage
localStorage.setItem('session', JSON.stringify(a));


        
}

const getlocalcart = () =>{
    cartArray = JSON.parse(localStorage.getItem('session'));
    
    if(cartArray)
    {
        if(cartDiv.children.length == 0){
        cartArray.map(function(item){
           let tableData = `
            <div class="cart-item">
                        <img src=${item.image} alt="product" />
                        <div>
                        <h4> ${item.name} </h4>
                        <h5> Rs ${item.price} </h5>
                        <span class="remove-item">remove</span>
                        </div>
                        <div>
                        <i class="fas fa-chevron-up increase"></i>
                        <p class="item-amount">
                            ${item.value}
                        </p>
                        <i class="fas fa-chevron-down decrease"></i>
                        </div>
            </div> 
            `

            let table = document.createElement('block')
            table.innerHTML = tableData;
            cartDiv.appendChild(table);

        })
    }}
} 

const deleteCartItem = (productName) => {
    cartArray = JSON.parse(localStorage.getItem('session'));
    
    if(cartArray){
        let output = cartArray.filter(item => {
            //console.log(productName, item.name)
            productName !== item.name
        })
        console.log(output)
        localStorage.setItem('session',JSON.stringify(output))
    }
}

latestProductsDiv.addEventListener('click', (e)=> {
    //window.location.href = './productdetails.html'
    
    displayAllProductsAjax().then(data => {latestProductsList(e,data)} )
        //console.log(result);
})
 
function latestProductsList(e,data){
    let pid = e.target.parentNode.dataset.id;
    let min = data[0].id;
   
    let item = data[pid - min]
    
    let display = 
         `
            <div class="col-2">
                    <img src=${item.img} width="100%" id="ProductImg">
           
            </div>
            <div class="col-2">
                
                <h1>${item.name}</h1>
                <h4> Rs ${item.price} </h4>
                <select>
                    <option>Large</option>
                    <option>Medium</option>
                    <option>Small</option>
                </select>
                <input class="quantity" type="number" value="1">
                <br />
                <a href="" class="btn addtocart">Add to Cart</a>
                <a href="" class="btn shopmore">Shop More</a>
                <h3>Product Details <i class="fa fa-indent"></i></h3>
                <br>
                    <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti dolor minima quas quis excepturi possimus reiciendis dolorem, cum ab odio sed aut itaque molestiae dicta ipsam, eius illo illum delectus. </p>
            </div>

        `
        
        
    productDetailsDiv.innerHTML = display;
    addtocart = document.querySelector('.addtocart');



    //smooth scroll
    //const productDetailsDivHeight = allProductsDiv.getBoundingClientRect().height;
    const pos = latestProductsDiv.getBoundingClientRect().height;
    const navHeight = nav.getBoundingClientRect().height;
    //console.log(productDetailsDivHeight)
    
    window.scrollTo ({
        left: 0,
        top: pos + navHeight + 200
    })

    //input quantity
    let qty = document.querySelector('.quantity');
    //console.log(qty.value)


//Add to cart event listener
    addtocart.addEventListener('click', e => {
        e.preventDefault();
   // console.log(element)
   
        
        addtocart.textContent = "Added";
    
        getlocalcart();

        let tableData = `
        <div class="cart-item">
                    <img src=${item.img} alt="product" />
                    <div>
                    <h4> ${item.name} </h4>
                    <h5> Rs ${item.price} </h5>
                    <span class="remove-item">remove</span>
                    </div>
                    <div>
                    <i class="fas fa-chevron-up increase"></i>
                    <p class="item-amount">
                        ${qty.value}
                    </p>
                    <i class="fas fa-chevron-down decrease"></i>
                    </div>
        </div> 
        `

        let table = document.createElement('block')
        table.innerHTML = tableData;
        cartDiv.appendChild(table);
    //save to local storage - object
    let image = item.img;
    let name = item.name;
    let price = item.price;
    let value = qty.value;

    let cartItem = {
        image , name, price, value
    }

    //call save local cart 
    savelocalcart(cartItem);
    //console.log(cartTotal.innerText == 0)
   // console.log(cartTotal.innerText)
    //cart total

    /* 
     if(cartTotal.innerText == 0){
        cartTotal.innerText = (parseInt(item.price) * parseInt(qty.value)).toString()
     } 
     else {
        cartTotal.innerText =  parseInt(cartTotal.innerText)  + (parseInt(item.price) * parseInt(qty.value))
     } */

    //calculate total cart price after loading
    let total = 0
     for(let i=0; i < cartDiv.children.length; i++){
         //console.log(cartDiv.children[i].childNodes[1].childNodes[3].childNodes[3].textContent.slice(3))
         let currPrice = cartDiv.children[i].childNodes[1].childNodes[3].childNodes[3].textContent.slice(3);
         let currqty = cartDiv.children[i].childNodes[1].childNodes[5].childNodes[3].textContent.trim()
         //console.log(cartDiv.children[i].childNodes[1].childNodes[5].childNodes[3].textContent.trim())

          total += parseInt(currPrice) * parseInt(currqty)
         
     }
   
     cartTotal.innerText = total;

    //make cart visible
    cart.classList.add('showCart');
    cartOverlay.style.visibility = "visible";

    
   

    //close btn
    
    const increaseBtn = document.querySelectorAll('.increase');
    const decreaseBtn = document.querySelectorAll('.decrease');
    const removeBtn = document.querySelectorAll('.remove-item')


    //handler for increase

    function increase(e){
        
        // console.log(item)
            let para = e.target.parentNode.childNodes[3];
    
            para.textContent = parseInt(para.textContent) + 1;
           
        //update cart total
            let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText
           // console.log(e.target.parentNode.parentNode.childNodes[3].childNodes[3])
            curr = curr.replace("Rs",'')
            //console.log(curr)
            //console.log(cartTotal.innerText)
            cartTotal.innerText =  parseInt(cartTotal.innerText)  + parseInt(curr) 
             
        
    }

    //handler for decrease
    function decrease(e){

            console.log(e.target.parentElement)
            let para = e.target.parentNode.childNodes[3];
            //stop decreasing after 0 and remove
            if(parseInt(para.innerText)==1){
                  //update cart total
                    let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText;
                    curr = curr.replace("Rs",'')
                    
                    //qty
                    let removeqty =  e.target.parentNode.parentNode.childNodes[5].childNodes[3].textContent.trim();
                    console.log(removeqty, curr)

                    let removeTotal = parseInt(curr) * parseInt(removeqty);

                cartTotal.innerText =  parseInt(cartTotal.innerText)  - parseInt(removeTotal) 

                e.target.parentElement.parentElement.remove();
            }

            else{
                 para.innerText = parseInt(para.innerText)- 1;

                //update cart total
                let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText
            // console.log(e.target.parentNode.parentNode.childNodes[3].childNodes[3])
                curr = curr.replace("Rs",'')
            //console.log(curr)
            //console.log(cartTotal.innerText)
                cartTotal.innerText =  parseInt(cartTotal.innerText)  - parseInt(curr) 
            }
           
             
        
    }

    function remove(e) {
        
           //e.target.parentElement.parentElement.remove();

             //update cart total
            let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText;
            curr = curr.replace("Rs",'')
            
            //qty
            let removeqty =  e.target.parentNode.parentNode.childNodes[5].childNodes[3].textContent.trim();
            console.log(removeqty, curr)

            let removeTotal = parseInt(curr) * parseInt(removeqty);

           cartTotal.innerText =  parseInt(cartTotal.innerText)  - parseInt(removeTotal) 

           e.target.parentElement.parentElement.remove();

           //remove from local storage
           //   console.log(e.target.parentElement.children[0].textContent)
           let productName = e.target.parentElement.children[0].textContent;
           deleteCartItem(productName);


    }

    closeBtn.addEventListener("click", (e)=> {
        cart.classList.remove('showCart');
    cartOverlay.style.visibility = "hidden";

    //clear out previous add event listeners
    increaseBtn.forEach(item => {
        
        item.removeEventListener('click',increase)

    })

    decreaseBtn.forEach(item => {
        
        item.removeEventListener('click',decrease)

    })


    removeBtn.forEach(item => {
        item.removeEventListener('click', remove)

    })

    })

    //increase btn
    increaseBtn.forEach(item => {
        
        item.addEventListener('click',increase)

    })


    //decrease btn
    decreaseBtn.forEach(item => {
        item.addEventListener('click',decrease)
    })

         
    //remove btn
    removeBtn.forEach(item => {
        item.addEventListener('click', remove)

    })

    clearBtn.addEventListener('click', (e)=>{
        while (cartDiv.firstChild) {
            cartDiv.removeChild(cartDiv.firstChild);

            cartTotal.innerText = 0
    }
    })

    

  
    
  //  savelocalcart({id:1, name:"loo"})
   // savelocalcart({id:2, name:"foo"})
   
   // getlocalcart(cartArray)
   
    
})


   
    
}

cartIcon.addEventListener('click', e => {
    console.log(e.target)
    
    //if cart is empty load from storage
    getlocalcart();

    //make cart visible
    cart.classList.add('showCart');
    cartOverlay.style.visibility = "visible";


    //total cost
     let total = 0
     for(let i=0; i < cartDiv.children.length; i++){
         //console.log(cartDiv.children[i].childNodes[1].childNodes[3].childNodes[3].textContent.slice(3))
         let currPrice = cartDiv.children[i].childNodes[1].childNodes[3].childNodes[3].textContent.slice(3);
         let currqty = cartDiv.children[i].childNodes[1].childNodes[5].childNodes[3].textContent.trim()
         //console.log(cartDiv.children[i].childNodes[1].childNodes[5].childNodes[3].textContent.trim())

          total += parseInt(currPrice) * parseInt(currqty)
         
     }
   
     cartTotal.innerText = total;


     //close btn
    
    const increaseBtn = document.querySelectorAll('.increase');
    const decreaseBtn = document.querySelectorAll('.decrease');
    const removeBtn = document.querySelectorAll('.remove-item')


    //handler for increase

    function increase(e){
        
        // console.log(item)
            let para = e.target.parentNode.childNodes[3];
    
            para.textContent = parseInt(para.textContent) + 1;
           
        //update cart total
            let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText
           // console.log(e.target.parentNode.parentNode.childNodes[3].childNodes[3])
            curr = curr.replace("Rs",'')
        //console.log(curr)
        //console.log(cartTotal.innerText)
        cartTotal.innerText =  parseInt(cartTotal.innerText)  + parseInt(curr) 
             
        
    }

    //handler for decrease
    function decrease(e){

        
            let para = e.target.parentNode.childNodes[3];
            //stop decreasing after 0 and remove
            if(parseInt(para.innerText)==1){
                  //update cart total
                    let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText;
                    curr = curr.replace("Rs",'')
                    
                    //qty
                    let removeqty =  e.target.parentNode.parentNode.childNodes[5].childNodes[3].textContent.trim();
                    console.log(removeqty, curr)

                    let removeTotal = parseInt(curr) * parseInt(removeqty);

                cartTotal.innerText =  parseInt(cartTotal.innerText)  - parseInt(removeTotal) 

                e.target.parentElement.parentElement.remove();
            }

            else{
                 para.innerText = parseInt(para.innerText)- 1;

                //update cart total
                let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText
            // console.log(e.target.parentNode.parentNode.childNodes[3].childNodes[3])
                curr = curr.replace("Rs",'')
            //console.log(curr)
            //console.log(cartTotal.innerText)
                cartTotal.innerText =  parseInt(cartTotal.innerText)  - parseInt(curr) 
            }
           
             
        
    }

    function remove(e) {
        
           //e.target.parentElement.parentElement.remove();

             //update cart total
            let curr = e.target.parentNode.parentNode.childNodes[3].childNodes[3].innerText;
            curr = curr.replace("Rs",'')
            
            //qty
            let removeqty =  e.target.parentNode.parentNode.childNodes[5].childNodes[3].textContent.trim();
            console.log(removeqty, curr)

            let removeTotal = parseInt(curr) * parseInt(removeqty);

           cartTotal.innerText =  parseInt(cartTotal.innerText)  - parseInt(removeTotal) 

           e.target.parentElement.parentElement.remove();

           //remove from local storage
           //   console.log(e.target.parentElement.children[0].textContent)
           let productName = e.target.parentElement.children[0].textContent;
           deleteCartItem(productName);


    }

    closeBtn.addEventListener("click", (e)=> {
        cart.classList.remove('showCart');
    cartOverlay.style.visibility = "hidden";

    //clear out previous add event listeners
    increaseBtn.forEach(item => {
        
        item.removeEventListener('click',increase)

    })

    decreaseBtn.forEach(item => {
        
        item.removeEventListener('click',decrease)

    })


    removeBtn.forEach(item => {
        item.removeEventListener('click', remove)

    })

    })

    //increase btn
    increaseBtn.forEach(item => {
        
        item.addEventListener('click',increase)

    })


    //decrease btn
    decreaseBtn.forEach(item => {
        item.addEventListener('click',decrease)
    })

         
    //remove btn
    removeBtn.forEach(item => {
        item.addEventListener('click', remove)

    })

    clearBtn.addEventListener('click', (e)=>{
        while (cartDiv.firstChild) {
            cartDiv.removeChild(cartDiv.firstChild);

            cartTotal.innerText = 0
    }
    })



})
