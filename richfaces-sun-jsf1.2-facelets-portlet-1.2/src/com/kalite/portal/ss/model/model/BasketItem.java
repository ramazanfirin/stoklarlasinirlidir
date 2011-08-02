package com.kalite.portal.ss.model.model;

public class BasketItem extends BaseModel{

	private Campaign campaign;
	private Integer count;
	
	public Campaign getCampaign() {
		return campaign;
	}
	public void setCampaign(Campaign campaign) {
		this.campaign = campaign;
	}
	public Integer getCount() {
		return count;
	}
	public void setCount(Integer count) {
		this.count = count;
	}
	
}
