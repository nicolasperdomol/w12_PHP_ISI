<!-- FOOTER -->
<footer>
    Designed by <?= $page_data['author'] ?> &copy;<br>
    <?= COMPANY_NAME . "<br>" ?>
    <?= COMPANY_STREET_ADDRESS . " " . COMPANY_CITY . " " . COMPANY_POSTAL_CODE . " " . COMPANY_COUNTRY . "<br>"  ?>
    <?= COMPANY_PHONE_NUMBER . " | " . COMPAY_EMAIL . "<br>"  ?>
    <?php echo "<br><span>List count: " . webpage::updateViewCounter("log/productsListCounter.txt") . "</span><br><span>Catalogue count: " . webpage::updateViewCounter("log/productsCatalogueCounter.txt") . "</span>" ?>;
</footer>
</div>
</body>

</html>