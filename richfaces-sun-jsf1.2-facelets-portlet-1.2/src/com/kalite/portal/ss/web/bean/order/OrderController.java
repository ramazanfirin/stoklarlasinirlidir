package com.kalite.portal.ss.web.bean.order;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import com.kalite.portal.ss.model.model.Basket;
import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.model.model.Order;
import com.kalite.portal.ss.web.bean.BaseController;

public class OrderController extends BaseController{

    private Date startDate;
    private Date endDate;
    private Long statusId;
	/**
	 * 
	 */
	private static final long serialVersionUID = -4138013717025265344L;
	private List<Order> orderList = new ArrayList<Order>();
	

	public String search(){
		orderList = getServiceProvider().getOrderManager().getMyOrders(getUserId());
		return "";
	}
	
	public String searchOrderList(){
		orderList = getServiceProvider().getOrderManager().searchOrder(startDate, endDate, statusId);
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
	
	public OrderController() {
		super();    
		// TODO Auto-generated constructor stub
	}

	public List<Order> getOrderList() {
		return orderList;
	}

	public void setOrderList(List<Order> orderList) {
		this.orderList = orderList;
	}
    
	
	
}
