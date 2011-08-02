package com.kalite.portal.ss.model.model;

import java.io.Serializable;
import java.util.Date;

public class Campaign extends BaseModel implements Serializable{

    /**
	 * 
	 */
	private static final long serialVersionUID = -6203434290814031427L;
	private String slogan;
	private Long stockCount;
	private Long sellingCount;
	private Double price;
	private Product product= new Product();
	private Date startDate;
	private Date finishDate;
	
	public String getSlogan() {
		return slogan;
	}

	public void setSlogan(String slogan) {
		this.slogan = slogan;
	}

	public Long getStockCount() {
		return stockCount;
	}

	public void setStockCount(Long stockCount) {
		this.stockCount = stockCount;
	}

	public Long getSellingCount() {
		return sellingCount;
	}

	public void setSellingCount(Long sellingCount) {
		this.sellingCount = sellingCount;
	}

	
    
	public static Campaign copyAttributes(Campaign source, Campaign target){
		BaseModel.copyAttributes(source, target);
		target.setSlogan(source.getSlogan());
		target.setStockCount(source.getStockCount());
		target.setSellingCount(source.getSellingCount());
		target.setPrice(source.getPrice());
		target.setProduct(source.getProduct());
		return target;
	}

	public static Campaign reset(Campaign campaign){
		BaseModel.resetAttributes(campaign);
		campaign.setSlogan(null);
		campaign.setStockCount(null);
		campaign.setSellingCount(null);
		campaign.setPrice(null);
		campaign.setProduct(null);
		return campaign;
	}

	public Double getPrice() {
		return price;
	}

	public void setPrice(Double price) {
		this.price = price;
	}

	public Product getProduct() {
		return product;
	}

	public void setProduct(Product product) {
		this.product = product;
	}

	public Date getStartDate() {
		return startDate;
	}

	public void setStartDate(Date startDate) {
		this.startDate = startDate;
	}

	public Date getFinishDate() {
		return finishDate;
	}

	public void setFinishDate(Date finishDate) {
		this.finishDate = finishDate;
	}
}
