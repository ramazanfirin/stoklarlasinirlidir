package com.kalite.portal.ss.service;

import com.kalite.portal.ss.service.manager.BasketManager;
import com.kalite.portal.ss.service.manager.CacheManager;
import com.kalite.portal.ss.service.manager.CampaignManager;
import com.kalite.portal.ss.service.manager.OrderManager;
import com.kalite.portal.ss.service.manager.ParameterManager;
import com.kalite.portal.ss.service.manager.ProductManager;


public class ServiceProvider {
	public ServiceProvider() {
		super();     
		System.out.println("stotkarlasinirlidir.com deploy edildi." );
	}

	private ProductManager productManager;
	private ParameterManager parameterManager;
	private CampaignManager campaignManager;
	private CacheManager cacheManager;
	private BasketManager basketManager;
	private OrderManager orderManager;
	
	public ParameterManager getParameterManager() {
		return parameterManager;
	}

	public void setParameterManager(ParameterManager parameterManager) {
		this.parameterManager = parameterManager;
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

	public CacheManager getCacheManager() {
		return cacheManager;
	}

	public void setCacheManager(CacheManager cacheManager) {
		this.cacheManager = cacheManager;
	}

	public BasketManager getBasketManager() {
		return basketManager;
	}

	public void setBasketManager(BasketManager basketManager) {
		this.basketManager = basketManager;
	}

	public OrderManager getOrderManager() {
		return orderManager;
	}

	public void setOrderManager(OrderManager orderManager) {
		this.orderManager = orderManager;
	}

}
