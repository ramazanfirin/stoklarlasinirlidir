package com.kalite.portal.ss.web.bean.basket;

import java.util.Date;

import javax.faces.application.FacesMessage;
import javax.faces.context.FacesContext;

import com.kalite.portal.ss.model.SSConstants;
import com.kalite.portal.ss.model.model.Basket;
import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.model.model.Order;
import com.kalite.portal.ss.web.bean.BaseController;

public class BasketController extends BaseController{


	private Basket basket;

	public String addToBasket(){
		Long id = new Long(getRequestParameter("id"));                                         
	    Campaign campaignTemp=getServiceProvider().getCacheManager().getActiveCampaignMap().get(id);  
		Basket basket= (Basket)getAttributeFromSession("basketTemp");
		if(basket==null)
			basket = new Basket();
		basket.getCampaignList().clear();
	    basket.getCampaignList().add(campaignTemp);
		setAttributeToSession("basketTemp", basket);
		return "";
	}
	
	public String deleteFromBasket(){
		Long id = new Long(getRequestParameter("id"));                                         
	    Campaign campaignTemp=getServiceProvider().getCacheManager().getActiveCampaignMap().get(id);  
		Basket basket= (Basket)getAttributeFromSession("basketTemp");
		basket.getCampaignList().remove(campaignTemp);
		setAttributeToSession("basketTemp", basket);
		return "";

	}
	
	public String buyBasket(){
		Basket basket= (Basket)getAttributeFromSession("basketTemp");
		Order order = new Order();
		order.setActive(true);
		order.setBasket(basket);
		order.setInsertDate(new Date());
		order.getStatus().setId(SSConstants.ORDER_STATUS_WAITING_FOR_APPROVE);
		order.setUserId(getUserId());
		getServiceProvider().getOrderManager().saveorupdate(order);
		setAttributeToSession("basketTemp", null);
		FacesContext.getCurrentInstance().addMessage("", new FacesMessage("Siparişiniz alınmıştır."));
		return "";
	}
	
	public void valueChangeListener(javax.faces.event.ValueChangeEvent event){
		event.getSource();
		event.getComponent();
		event.getNewValue();
		event.getOldValue();
	}
	
	public BasketController() {
		super();    
		// TODO Auto-generated constructor stub
	}



	public Basket getBasket() {
		Object object =getAttributeFromSession("basketTemp");
		if(object !=null)
			return (Basket)object;
		return null;
	}

	public void setBasket(Basket basket) {
		this.basket = basket;
	}
    
	
	
}
