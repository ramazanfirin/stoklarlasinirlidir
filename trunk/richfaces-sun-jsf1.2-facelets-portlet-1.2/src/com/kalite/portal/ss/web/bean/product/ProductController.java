package com.kalite.portal.ss.web.bean.product;

import java.util.ArrayList;
import java.util.List;

import javax.faces.component.html.HtmlDataTable;
import javax.faces.context.FacesContext;

import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.service.ServiceProvider;
import com.kalite.portal.ss.web.bean.BaseController;

public class ProductController extends BaseController{


	private transient Product product;
	
	private List<Product> productList = new ArrayList<Product>();
	private HtmlDataTable productDataTable;
	private Product selectedProduct;
	
	public String submit(){
		ServiceProvider serviceProvider=getServiceProvider();    
		serviceProvider.getProductManager().saveorupdate(product);
		
	    System.out.println("productcontrollersubmit ");
		return gotoResultPage();
	}
	

	
	public String editProduct(){
	       FacesContext context = FacesContext.getCurrentInstance();
	       String id = (String)context.getExternalContext().getRequestParameterMap().get("id");
	       //Product productTemp = getServiceProvider().getProductManager().findProduct(new Long(id));
	       Product productTemp=getServiceProvider().getProductManager().findProduct(new Long(id));
	       //product = new Product();
	       Product.copyAttributes(productTemp, product);    
	       return gotoUpdatePage();   
	}
	     
	public String addProduct(){
	       Product.reset(product);   
	       return gotoUpdatePage();   
	}
	
	
	
	public List<Product> getProductList(){
		return getServiceProvider().getProductManager().getProductList();
	}
	
	public Product getProduct() {
		return product;
	}
	public void setProduct(Product product) {
		this.product = product;
	}
	public String getTemp() {
		return temp;
	}
	public void setTemp(String temp) {
		this.temp = temp;
	}
	private String temp="deneme";

	public HtmlDataTable getProductDataTable() {
		return productDataTable;
	}

	public void setProductDataTable(HtmlDataTable productDataTable) {
		this.productDataTable = productDataTable;
	}

	public void setProductList(List<Product> productList) {
		this.productList = productList;
	}

	public Product getSelectedProduct() {
		return selectedProduct;
	}

	public void setSelectedProduct(Product selectedProduct) {
		this.selectedProduct = selectedProduct;
	}
	
}
