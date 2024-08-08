<?php
class Auction {
    private $conn;
    private $table_name = "auctions";

    public $id;
    public $product_name;
    public $image;
    public $starting_price;
    public $expiry_date;
    public $highest_bid;

    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function create(): bool {
        $query = "INSERT INTO " . $this->table_name . " SET product_name=:product_name, image=:image, starting_price=:starting_price, expiry_date=:expiry_date";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":starting_price", $this->starting_price);
        $stmt->bindParam(":expiry_date", $this->expiry_date);

        return $stmt->execute();
    }

    public function readAll(): PDOStatement {
        $query = "SELECT * FROM " . $this->table_name . " WHERE expiry_date > NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
?>
