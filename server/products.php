<?php
class products
{
    // list of 6 products as it would be retrieved from a database
    const products = [
        [
            'id' => 0,
            'name' => 'Red Jersey',
            'description' => 'Manchester United Home Jersey, red, sponsored by Chevrolet',
            'price' => 59.99,
            'pic' => 'red_jersey.jpg',
            'qty_in_stock' => 200,
        ],
        [
            'id' => 1,
            'name' => 'White Jersey',
            'description' => 'Manchester United Away Jersey, white, sponsored by Chevrolet',
            'price' => 49.99,
            'pic' => 'white_jersey.jpg',
            'qty_in_stock' => 133,
        ],
        [
            'id' => 2,
            'name' => 'Black Jersey',
            'description' => 'Manchester United Extra Jersey, black, sponsored by Chevrolet',
            'price' => 54.99,
            'pic' => 'black_jersey.jpg',
            'qty_in_stock' => 544,
        ],
        [
            'id' => 3,
            'name' => 'Blue Jacket',
            'description' => 'Blue Jacket for cold and raniy weather',
            'price' => 129.99,
            'pic' => 'blue_jacket.jpg',
            'qty_in_stock' => 14,
        ],
        [
            'id' => 4,
            'name' => 'Snapback Cap',
            'description' => 'Manchester United New Era Snapback Cap- Adult',
            'price' => 24.99,
            'pic' => 'cap.jpg',
            'qty_in_stock' => 655,
        ],
        [
            'id' => 5,
            'name' => 'Champion Flag',
            'description' => 'Manchester United Champions League Flag',
            'price' => 24.99,
            'pic' => 'champion_league_flag.jpg',
            'qty_in_stock' => 321,
        ],
    ];


    function __construct()
    {
        //parent::__construct();
    }

    function __destruct()
    {
    }


    public static function productsList()
    {
        $page_data = DEFAULT_PAGE_DATA;
        viewCount("log/productsListCounter.txt");
        $product_keys = array_keys(self::products[0]);

        $productList = "<table class=\"productsList\"><tr>";
        foreach ($product_keys as $key) {
            $productList .= "<th>$key</th>";
        }
        $productList .= "</tr>";
        foreach (self::products as $product) {
            foreach ($product as $value) {
                $productList .= "<td>$value</td>";
            }
            $productList .= "</tr>";
        }
        $productList .= "</table>";
        $page_data['content'] = $productList;
        webpage::render($page_data);
    }

    public static function productsCatalogue()
    {
        $page_data = DEFAULT_PAGE_DATA;
        viewCount("log/productsCatalogueCounter.txt");
        $productCatalogue = "<table><tr>";
        foreach (self::products as $product) {
            $productCatalogue .= "<td class=\"product\">";
            $productCatalogue .= "<div><img title=\"" . $product["name"] . "\" src=\"" . PATH . $product["pic"] . "\"></div>";
            $productCatalogue .= "<div class='name'>" . $product["name"] . "</div>";
            $productCatalogue .= "<div class='description'>" . $product["description"] . "</div>";
            $productCatalogue .= "<div class=\"price\">" . $product["price"] . "</div>";
            $productCatalogue .= "</td>";
        }
        $productCatalogue .= "</tr></table>";

        $page_data['content'] = $productCatalogue;
        webpage::render($page_data);
    }
}
