package com.kalite.portal.ss.web.bean.welcome;

import javax.faces.context.FacesContext;
import javax.portlet.PortletSession;

import com.kalite.portal.ss.model.model.Basket;
import com.kalite.portal.ss.model.model.Campaign;
import com.kalite.portal.ss.web.bean.BaseController;

public class WelcomeController extends BaseController{


	/**
	 * 
	 */
	private static final long serialVersionUID = 6809244849859630964L;
	private Campaign campaign;
	private String name;
	
    public String select(){
	       Long id = new Long(getRequestParameter("id"));                                         
	       Campaign campaign=getServiceProvider().getCacheManager().getActiveCampaignMap().get(id);  
	       setAttributeToSession("campaignTemp",campaign); 
	       return "";   
	}
    
   
	public Campaign getCampaign() {
		Object object =getAttributeFromSession("campaignTemp");
		if(object !=null)
			return (Campaign)object;              
		return null;
     
	}     

	public WelcomeController() {
		super();                 
		Campaign campaign=getServiceProvider().getCacheManager().getActiveCampaignList().get(0);  
	    setAttributeToSession("campaignTemp",campaign); 
		
	}

	public void setCampaign(Campaign campaign) {    
		System.out.println("set campaign is running");
		this.campaign = campaign;
	}


	public String getName() {
		System.out.println("getname = "+name);
		return name;
	}     


	public void setName(String name) {
		System.out.println("setname = "+name);
		this.name = name;
	}
	
}
