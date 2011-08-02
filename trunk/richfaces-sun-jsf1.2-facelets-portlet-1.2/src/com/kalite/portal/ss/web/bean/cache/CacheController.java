package com.kalite.portal.ss.web.bean.cache;

import java.util.List;

import javax.faces.model.SelectItem;

import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.web.bean.BaseController;

public class CacheController extends BaseController{
 
    public List<SelectItem> getProductListSelectItem() {
		return getServiceProvider().getCacheManager().getProductListSelectItem();
	}

    public List<Campaign> getActiveCampaignList() {
    	return getServiceProvider().getCacheManager().getActiveCampaignList();
	}

    public List<SelectItem> getOrderStatusSelectItemList() {
    	return getServiceProvider().getCacheManager().getOrderStatusSelectItemList();
	}
    
	public CacheController() {
		super();
		// TODO Auto-generated constructor stub
	}

}
