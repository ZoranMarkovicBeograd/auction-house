<?php
require_once '../config/Database.php';
require_once '../Models/Auction.php';
require_once '../Models/Bid.php';

class AuctionController {
    private $db;
    private $auction;
    private $bid;

    public function __construct() {
        $this->db = new Database();
        $this->auction = new Auction($this->db);
        $this->bid = new Bid($this->db);
    }

    public function createAuction(string $product_name, string $image, float $starting_price, string $expiry_date): bool {
        $this->auction->product_name = $product_name;
        $this->auction->image = $image;
        $this->auction->starting_price = $starting_price;
        $this->auction->expiry_date = $expiry_date;
        return $this->auction->create();
    }

    public function placeBid(int $auction_id, int $user_id, float $bid_amount): bool {
        if ($this->bid->isLastBidder($auction_id, $user_id)) {
            return false;
        }

        $highest_bid = $this->bid->getHighestBid($auction_id);
        if ($bid_amount <= $highest_bid) {
            return false;
        }

        $this->bid->auction_id = $auction_id;
        $this->bid->user_id = $user_id;
        $this->bid->bid_amount = $bid_amount;
        return $this->bid->create();
    }

    public function getAuctions(): PDOStatement {
        return $this->auction->readAll();
    }
}
?>
