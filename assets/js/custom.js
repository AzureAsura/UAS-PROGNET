$(document).ready(function () {
  // $('.increment_btn').click(function(e){
  $(document).on("click", ".increment_btn", function (e) {
    e.preventDefault();

    var qty = $(this).closest(".product-data").find(".qty-input").val();

    var value = parseInt(qty, 10);
    value = isNaN(value) ? 0 : value;
    if (value < 10) {
      value++;
      $(this).closest(".product-data").find(".qty-input").val(value);
    }
  });

  $(document).on("click", ".decrement_btn", function (e) {
    e.preventDefault();

    var qty = $(this).closest(".product-data").find(".qty-input").val();

    var value = parseInt(qty, 10);
    value = isNaN(value) ? 0 : value;
    if (value > 0) {
      value--;
      $(this).closest(".product-data").find(".qty-input").val(value);
    }
  });

  $(document).on("click", ".add-to-cart", function (e) {
    e.preventDefault();

    var qty = $(this).closest(".product-data").find(".qty-input").val();
    var prod_id = $(this).val();

    $.ajax({
      method: "POST",
      url: "proses/proses-cart.php",
      data: {
        id_produk: prod_id,
        prod_qty: qty,
        scope: "add",
      },
      dataType: "json",
      success: function (response) {
        if (response.status == 201) {
          showToast(response.message);
        } else {
          showToast(response.message);
        }
      },
    });
  });

  $(document).on("click", ".updateQty", function () {
    var qty = $(this).closest(".product-data").find(".qty-input").val();
    var prod_id = $(this).closest(".product-data").find(".prodid").val();
    var cart_id = $(this).closest(".product-data").find(".cartid").val();

    $.ajax({
      method: "POST",
      url: "proses/proses-cart.php",
      data: {
        id_cart: cart_id,
        id_produk: prod_id,
        prod_qty: qty,
        scope: "update",
      },
      dataType: "json",
      success: function (response) {
        $("#mycart").load(location.href + " #mycart > *");
      },
    });
  });

  $(document).on("click", ".deleteItem", function () {
    var cart_id = $(this).val();

    $.ajax({
      method: "POST",
      url: "proses/proses-cart.php",
      data: {
        id_cart: cart_id,
        scope: "delete",
      },
      dataType: "json",
      success: function (response) {
        if (response.status == 200) {
          showToast(response.message);
          // $('#mycart').load(location.href + " #mycart")
          $("#mycart").load(location.href + " #mycart > *");
        } else {
          showToast(response.message);
        }
      },
    });
  });
});

function showToast(message) {
  $("#dynamic-toast").remove();

  const toastHTML = `
        <div id="dynamic-toast"
            class="fixed bottom-6 right-6 z-50 flex items-start gap-3 w-[340px] p-4
                   bg-white/90 backdrop-blur-md
                   border border-slate-200
                   rounded-2xl shadow-xl
                   text-slate-800
                   animate-toast-in">

            <!-- Icon -->
            <div class="flex-shrink-0 mt-0.5">
                <i class="ri-checkbox-circle-line text-xl"></i>
            </div>

            <!-- Message -->
            <div class="flex-1 mt-1">
                <p class="text-sm font-medium leading-relaxed">
                    ${message}
                </p>
            </div>

            <!-- Close -->
            <button 
                onclick="closeDynamicToast()"
                class="text-slate-400 hover:text-slate-600 transition">
                <i class="ri-close-line text-lg"></i>
            </button>
        </div>
    `;

  $("body").append(toastHTML);

  setTimeout(toastHTML, 4000);
}

$(document).ready(function () {
  let index = 0;
  const items = $("#categoryCarousel a");

  function perView() {
    if (window.innerWidth >= 768) return 6;
    if (window.innerWidth >= 640) return 3;
    return 2;
  }

  function update() {
    const width = items.outerWidth(true);
    $("#categoryCarousel").css("transform", `translateX(${-index * width}px)`);
  }

  $("#nextCat").click(() => {
    if (index < items.length - perView()) {
      index++;
      update();
    }
  });

  $("#prevCat").click(() => {
    if (index > 0) {
      index--;
      update();
    }
  });

  $(window).resize(update);
});
