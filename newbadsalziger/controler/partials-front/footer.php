



 </div> 
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>   
    //menüToggle

    
    let toggle = document.querySelector(".toggle");
    let navigation = document.querySelector(".navigation-is");
    let main = document.querySelector(".main");

    toggle.onclick = function(){
        navigation.classList.toggle("active");
        main.classList.toggle("active");
    }



    //add hovered class in slected list item 
    /*let list = document.querySelectorAll('.navigation-is li');
    function activeLink(){
        list.forEach((item)=>
        item.classList.remove('hovered'));
        this.classList.add('hovered');
    }
    list.forEach((item)=>
    item.addEventListener('mouseover',activeLink));
*/
 
</script>


















  <!-- JavaScript içinde modal fonksiyonları -->
<script>
    // Modalı açma fonksiyonu
    function openPdfModal(cartId) {
        var modal = document.getElementById("pdfModal-" + cartId);
        modal.style.display = "block";

        // PDF dosyasının URL'sini belirtin (generate_pdf.php dosyasını kendi projenize uygun olarak değiştirin)
        var pdfUrl = "print.php?cart_id=" + cartId;

        // PDF'yi iframe içinde gösterin
        document.getElementById("pdfFrame-" + cartId).src = pdfUrl;
    }

    // Modalı kapatma fonksiyonu
    function closePdfModal(cartId) {
        var modal = document.getElementById("pdfModal-" + cartId);
        modal.style.display = "none";

        // PDF iframe'ini sıfırlayın
        document.getElementById("pdfFrame-" + cartId).src = "";
    }
</script>  


























</body>
</html>