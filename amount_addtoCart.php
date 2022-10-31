<script>
    const btn_decrease = document.querySelector("#decrease");
    const show_amount = document.querySelector("#show_amount");
    const btn_increase = document.querySelector("#increase");
    const btn_addtoCart = document.querySelector('#btn_addtoCart');
    
    var number_change = 1;
    btn_decrease.onclick = ()=>{
        number_change --;
        if(number_change < 1){
            number_change = 1;
        }
        show_amount.value = number_change;
    }

    btn_increase.onclick = ()=>{
        console.log('tang roi');
        number_change ++;
        show_amount.value = number_change;
    }

    btn_addtoCart.onclick = ()=>{
        window.location.href = `add_to_cart.php?id=<?= $_GET['id']?>&amount_product=${number_change}`;
    }

</script>