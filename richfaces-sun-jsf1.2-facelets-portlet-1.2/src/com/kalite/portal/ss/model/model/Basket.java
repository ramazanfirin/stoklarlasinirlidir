package com.kalite.portal.ss.model.model;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

public class Basket extends BaseModel{

	private List<Campaign> campaignList = new ArrayList<Campaign>();

	public List<Campaign> getCampaignList() {
		return campaignList;
	}

	public void setCampaignList(List<Campaign> campaignList) {
		this.campaignList = campaignList;
	}
	
	public String getProductNames(){
		String result="";
		for (Iterator iterator = campaignList.iterator(); iterator.hasNext();) {
			Campaign campaign = (Campaign) iterator.next();
			result=result+","+campaign.getProduct().getName();
		}
		return result;
	}

	public Campaign getCampaign() {
		if(campaignList!=null &&campaignList.size()>0)
			return campaignList.get(0);
		else
			return new Campaign();
	}


	
}
