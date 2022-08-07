<!-- FOOTER -->
<footer>
    Designed by <?= $page_data['author'] ?> &copy;<br>
    <?= COMPANY_NAME . "<br>" ?>
    <?= COMPANY_STREET_ADDRESS . " " . COMPANY_CITY . " " . COMPANY_POSTAL_CODE . " " . COMPANY_COUNTRY . "<br>"  ?>
    <?= COMPANY_PHONE_NUMBER . " | " . COMPAY_EMAIL . "<br>"  ?>
    <?php echo "<br><span>List count: " . webpage::updateViewCounter("log/productsListCounter.txt") . "</span><br><span>Catalogue count: " . webpage::updateViewCounter("log/productsCatalogueCounter.txt") . "</span>" ?>;
</footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>