package com.kalite.portal.ss.web.bean;

import java.io.Serializable;

import javax.faces.context.FacesContext;
import javax.portlet.PortletContext;
import javax.portlet.PortletSession;

import org.springframework.web.context.WebApplicationContext;

import com.kalite.portal.ss.service.ServiceProvider;

public class BaseController implements Serializable {

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;

	public ServiceProvider getServiceProvider(){
		FacesContext facesContext = FacesContext.getCurrentInstance();
	    PortletContext context = (PortletContext)facesContext.getExternalContext().getContext();	
		WebApplicationContext springContext = (WebApplicationContext)   
        					context.getAttribute(WebApplicationContext.ROOT_WEB_APPLICATION_CONTEXT_ATTRIBUTE);
		ServiceProvider serviceProvider=(ServiceProvider)springContext.getBean("serviceProvider");
		return serviceProvider;
	}
	
	public String getRequestParameter(String parameter){
		 FacesContext context = FacesContext.getCurrentInstance();
		 return (String)context.getExternalContext().getRequestParameterMap().get(parameter);
	     
	}
	
	public Object getAttributeFromSession(String name){
		Object objSession = FacesContext.getCurrentInstance().getExternalContext().getSession(false);
		Object object=null;
        if (objSession instanceof PortletSession)
        {
           PortletSession portalSession = (PortletSession)objSession;
          object= portalSession.getAttribute(name,PortletSession.APPLICATION_SCOPE);
        }
        return object;
	}
	
	public void setAttributeToSession(String name,Object object){
		Object objSession = FacesContext.getCurrentInstance().getExternalContext().getSession(false);
		
        if (objSession instanceof PortletSession)
        {
           PortletSession portalSession = (PortletSession)objSession;
          portalSession.setAttribute(name,object,PortletSession.APPLICATION_SCOPE);
        }
        
	}
	
	public Long getUserId(){
		String  userId=FacesContext.getCurrentInstance().getExternalContext().getRemoteUser();
		if(userId!=null)
			return new Long(userId);
		else return null;
	}
	
	public String gotoViewPage(){
		return "gotoViewPage";
	}
	
	public String gotoUpdatePage(){
		return "gotoUpdatePage";
	}
	
	public String gotoResultPage(){
		return "gotoResultPage";
	}
}
