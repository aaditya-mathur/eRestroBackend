<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_payment_statistics extends CI_Migration
{
    public function up()
    {
        // 1. Create table order_transaction
        if (!$this->db->table_exists('order_transaction')) {
            $this->dbforge->add_field([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ],
                'order_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ],
                'partner_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ],
                'rider_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL
                ],
                'admin_payment' => [
                    'type' => 'FLOAT',
                    'null' => TRUE,
                    'default' => NULL
                ],
                'partner_payment' => [
                    'type' => 'FLOAT',
                    'null' => TRUE,
                    'default' => NULL
                ],
                'rider_payment' => [
                    'type' => 'FLOAT',
                    'null' => TRUE,
                    'default' => NULL
                ],
                'delivery_tip' => [
                    'type' => 'FLOAT',
                    'null' => FALSE,
                    'default' => 0
                ],
                'total_amount' => [
                    'type' => 'FLOAT',
                    'null' => FALSE
                ],
                'settelment_status' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => FALSE
                ]
            ]);
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('order_transaction');
        }

        // 4. Add city_id column to cart table
        if (!$this->db->field_exists('city_id', 'cart')) {
            $fields = [
                'city_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL,
                    'after' => 'product_variant_id'
                ]
            ];
            $this->dbforge->add_column('cart', $fields);
        }

        // 5. Add city_id column to cart_add_ons table
        if (!$this->db->field_exists('city_id', 'cart_add_ons')) {
            $fields = [
                'city_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => TRUE,
                    'default' => NULL,
                    'after' => 'user_id'
                ]
            ];
            $this->dbforge->add_column('cart_add_ons', $fields);
        }

        // 6. Add rejected_riders column to pending_orders table
        if (!$this->db->field_exists('rejected_riders', 'pending_orders')) {
            $fields = [
                'rejected_riders' => [
                    'type' => 'LONGTEXT',
                    'null' => TRUE,
                    'default' => NULL,
                    'after' => 'city_id'
                ]
            ];
            $this->dbforge->add_column('pending_orders', $fields);
        }

        if ($this->db->table_exists('cart')) {
            $this->db->query("DELETE FROM `cart`");
        }

        // 2. Delete all records from cart_add_ons table
        if ($this->db->table_exists('cart_add_ons')) {
            $this->db->query("DELETE FROM `cart_add_ons`");
        }
    }

    public function down()
    {
        // Drop the order_transaction table
        if ($this->db->table_exists('order_transaction')) {
            $this->dbforge->drop_table('order_transaction', TRUE);
        }

        // Remove added columns if exist
        if ($this->db->field_exists('city_id', 'cart')) {
            $this->dbforge->drop_column('cart', 'city_id');
        }

        if ($this->db->field_exists('city_id', 'cart_add_ons')) {
            $this->dbforge->drop_column('cart_add_ons', 'city_id');
        }

        if ($this->db->field_exists('rejected_riders', 'pending_orders')) {
            $this->dbforge->drop_column('pending_orders', 'rejected_riders');
        }
    }
}
