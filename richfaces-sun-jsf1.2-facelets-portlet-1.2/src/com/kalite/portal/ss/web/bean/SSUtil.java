package com.kalite.portal.ss.web.bean;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import javax.faces.model.SelectItem;

import com.kalite.portal.ss.model.model.Order;
import com.kalite.portal.ss.model.model.OrderStatus;
import com.kalite.portal.ss.model.model.Product;

public class SSUtil {
	public static List<SelectItem> convertToSelectItem(List<Product> products ){
		List<SelectItem> items = new ArrayList<SelectItem>();
		items.add(new SelectItem("","Seçiniz"));
		
		for (Iterator iterator = products.iterator(); iterator.hasNext();) {
			Product product = (Product) iterator.next();
			items.add(new SelectItem(product.getId(),product.getName()));
		}
		
		return items;
	}
	
	public static List<SelectItem> convertOrderStatusToSelectItem(List<OrderStatus> orderStatusList ){
		List<SelectItem> items = new ArrayList<SelectItem>();
		items.add(new SelectItem("","Seçiniz"));
		
		for (Iterator iterator = orderStatusList.iterator(); iterator.hasNext();) {
			Order order = (Order) iterator.next();
			items.add(new SelectItem(order.getId(),order.getName()));
		}
		
		return items;
	}

}
