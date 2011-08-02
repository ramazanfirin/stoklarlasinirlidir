package com.kalite.portal.ss.web.bean.campaign;

import java.util.ArrayList;
import java.util.List;

import javax.faces.model.SelectItem;

import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.service.ServiceProvider;
import com.kalite.portal.ss.web.bean.BaseController;
import com.kalite.portal.ss.web.bean.SSUtil;

public class CampaignController extends BaseController{


	private transient Campaign campaign;
    private List<Campaign> campaignList = new ArrayList<Campaign>();
    private List<SelectItem> productListSelectItem=null;
	
	public String save(){
		ServiceProvider serviceProvider=getServiceProvider();    
		serviceProvider.getProductManager().saveorupdate(campaign);
		return gotoResultPage();
	}

	public String edit(){
	       Long id = new Long(getRequestParameter("id"));    
	       Campaign campaignTemp=getServiceProvider().getCampaignManager().findCampaign(new Long(id));
	       Campaign.copyAttributes(campaignTemp, campaign);    
	       return gotoUpdatePage();   
	}
	     
	public String add(){
		   Campaign.reset(campaign);   
	       return gotoUpdatePage();   
	}

	public String search(){
		   campaignList = getServiceProvider().getCampaignManager().getCampaignList();  
	       return "";   
	}
	
	public String gotoViewPage(){
		campaignList = new ArrayList<Campaign>();
		return "gotoViewPage";
	}
	
	public Campaign getCampaign() {
		return campaign;
	}   

	public void setCampaign(Campaign campaign) {
		this.campaign = campaign;
	}

	public List<Campaign> getCampaignList() {
		return campaignList;
	}

	public void setCampaignList(List<Campaign> campaignList) {
		this.campaignList = campaignList;
	}
          
	public List<SelectItem> getProductListSelectItem() {
		if(productListSelectItem==null){
			List<Product> productList = getServiceProvider().getProductManager().getProductList();
			productListSelectItem = SSUtil.convertToSelectItem(productList);
		}
		return productListSelectItem;    
	}

	public void setProductListSelectItem(List<SelectItem> productListSelectItem) {
		this.productListSelectItem = productListSelectItem;
	}
	
}
