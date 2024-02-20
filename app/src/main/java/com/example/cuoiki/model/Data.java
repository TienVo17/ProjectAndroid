package com.example.cuoiki.model;

public class Data {

    private int price;
    private int id;
    private String name;
    private int is_active;
    private int room_type_id;

    public Data(int price, String name, int room_type_id) {
        this.price = price;
        this.name = name;
        this.room_type_id = room_type_id;
    }

    public int getRoom_type_id() {
        return room_type_id;
    }

    public void setRoom_type_id(int room_type_id) {
        this.room_type_id = room_type_id;
    }


    public int getPrice() {
        return price;
    }

    public void setPrice(int price) {
        this.price = price;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public int getIs_active() {
        return is_active;
    }

    public void setIs_active(int is_active) {
        this.is_active = is_active;
    }
}
