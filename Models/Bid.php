<?php
class Bid {
    private $conn;
    private $table_name = "bids";

    public $id;
    public $auction_id;
    public $user_id;
    public $bid_amount;

    public function __construct($db) {
        $this->conn = $db->conn;
    }

    public function create(): bool {
        $query = "INSERT INTO " . $this->table_name . " SET auction_id=:auction_id, user_id=:user_id, bid_amount=:bid_amount";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":auction_id", $this->auction_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":bid_amount", $this->bid_amount);

        return $stmt->execute();
    }

    public function getHighestBid(int $auction_id): float {
        $query = "SELECT MAX(bid_amount) as highest_bid FROM " . $this->table_name . " WHERE auction_id = :auction_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":auction_id", $auction_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float)$row['highest_bid'];
    }

    public function isLastBidder(int $auction_id, int $user_id): bool {
        $query = "SELECT user_id FROM " . $this->table_name . " WHERE auction_id = :auction_id ORDER BY id DESC LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":auction_id", $auction_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['user_id'] == $user_id;
    }
}
?>
