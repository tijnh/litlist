    <script>
      //Get the button
      let backToTopBtn = document.getElementById("btn-back-to-top");

      // When the user scrolls down ...px from the top of the document, show the button
      window.onscroll = function() {
        scrollFunction();
      };

      function scrollFunction() {
        if (
          document.body.scrollTop > 1500 ||
          document.documentElement.scrollTop > 1500
        ) {
          backToTopBtn.style.display = "block";
        } else {
          backToTopBtn.style.display = "none";
        }
      }
      // When the user clicks on the button, scroll to the top of the document
      backToTopBtn.addEventListener("click", backToTop);

      function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    </body>

    </html>