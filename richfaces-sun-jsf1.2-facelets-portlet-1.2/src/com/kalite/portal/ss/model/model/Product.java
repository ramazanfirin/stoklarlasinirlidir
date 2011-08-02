package com.kalite.portal.ss.model.model;

public class Product {
	private Long id;
	private String active;
	private String name;
	private String brand;
	private String type;
    private String imageUrl;
	
	public String getBrand() {
		return brand;
	}
	public void setBrand(String brand) {
		this.brand = brand;
	}
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
	}
    public Long getId() {
		return id;
	}
	public void setId(Long id) {
		this.id = id;
	}
	
	
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	
	public String getActive() {
		return active;
	}
	public void setActive(String active) {
		this.active = active;
	}
	
	public String getImageUrl() {
		return imageUrl;
	}
	public void setImageUrl(String imageUrl) {
		this.imageUrl = imageUrl;
	}
	
	public static Product copyAttributes(Product source, Product target){
		target.setActive(source.getActive());
		target.setBrand(source.getBrand());
		target.setId(source.getId());
		target.setImageUrl(source.getImageUrl());
		target.setName(source.getName());
		target.setType(source.getType());
		return target;
	}

	public static Product reset(Product product){
		product.setActive(null);
		product.setBrand(null);
		product.setId(null);
		product.setImageUrl(null);
		product.setName(null);
		product.setType(null);
		return product;
	}
}
