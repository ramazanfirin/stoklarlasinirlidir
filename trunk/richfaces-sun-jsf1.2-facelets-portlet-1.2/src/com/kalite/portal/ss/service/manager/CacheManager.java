package com.kalite.portal.ss.service.manager;

import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

import javax.faces.model.SelectItem;

import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.model.model.OrderStatus;
import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.web.bean.SSUtil;

public class CacheManager {

	private ProductManager productManager;
	private CampaignManager campaignManager;
	private ParameterManager parameterManager;

	private List<SelectItem> productListSelectItem=null;
    
    
    private Map<Long,Product> productMap;
    private List<Product> productList;
    
    private List<Campaign> activeCampaignList=null;
    private Map<Long,Campaign> activeCampaignMap=null;
    
    private List<SelectItem> orderStatusSelectItemList=null;
    private List<OrderStatus> orderStatusList;
    
    public List<SelectItem> getProductListSelectItem() {
			if(productListSelectItem==null){
				List<Product> productList = getProductList();
				productListSelectItem = SSUtil.convertToSelectItem(productList);
			}
			return productListSelectItem;    
	}

	public void setProductListSelectItem(List<SelectItem> productListSelectItem) {
		this.productListSelectItem = productListSelectItem;
	}

	public List<Campaign> getActiveCampaignList() {
		if(activeCampaignList==null)
			activeCampaignList = campaignManager.getActiveCampaigns(new Date());
		return activeCampaignList;
	}

	public void setActiveCampaignList(List<Campaign> activeCampaignList) {
		this.activeCampaignList = activeCampaignList;
	}

	public ProductManager getProductManager() {
		return productManager;
	}

	public void setProductManager(ProductManager productManager) {
		this.productManager = productManager;
	}

	public CampaignManager getCampaignManager() {
		return campaignManager;
	}

	public void setCampaignManager(CampaignManager campaignManager) {
		this.campaignManager = campaignManager;
	}

	public Map<Long, Product> getProductMap() {
		if(productMap==null){
			List<Product> products = getProductList();
			for (Iterator iterator = products.iterator(); iterator.hasNext();) {
				Product product = (Product) iterator.next();
				productMap.put(product.getId(),product);
			}
		}
		return productMap;
	}

	public void setProductMap(Map<Long, Product> productMap) {
		this.productMap = productMap;
	}

	public List<Product> getProductList() {
		if(productList==null){
			productList = productManager.getProductList();
		}
		return productList;
	}

	public void setProductList(List<Product> productList) {
		this.productList = productList;
	}

	public Map<Long, Campaign> getActiveCampaignMap() {
		if(activeCampaignMap==null){
			activeCampaignMap = new HashMap<Long,Campaign>();
			List<Campaign> campaigns = getActiveCampaignList();
			for (Iterator iterator = campaigns.iterator(); iterator.hasNext();) {
				Campaign campaign = (Campaign) iterator.next();
				activeCampaignMap.put(campaign.getId(),campaign);
			}
		}
		return activeCampaignMap;
	}

	public void setActiveCampaignMap(Map<Long, Campaign> activeCampaignMap) {
		this.activeCampaignMap = activeCampaignMap;
	}

	public List<SelectItem> getOrderStatusSelectItemList() {
		if(orderStatusSelectItemList==null){
			List<OrderStatus> orderStatusList = getOrderStatusList();
			orderStatusSelectItemList = SSUtil.convertOrderStatusToSelectItem(orderStatusList);
		}
		return orderStatusSelectItemList;
	}

	public void setOrderStatusSelectItemList(
			List<SelectItem> orderStatusSelectItemList) {
		this.orderStatusSelectItemList = orderStatusSelectItemList;
	}

	public List<OrderStatus> getOrderStatusList() {
		if(orderStatusList==null){
			orderStatusList = parameterManager.getOrderStatusList();
		}
		return orderStatusList;
	}

	public void setOrderStatusList(List<OrderStatus> orderStatusList) {
		this.orderStatusList = orderStatusList;
	}
	
}
