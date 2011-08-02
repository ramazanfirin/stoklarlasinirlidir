package com.kalite.portal.ss.service.manager;

import java.util.Date;
import java.util.List;

import org.springframework.transaction.annotation.Transactional;

import com.kalite.portal.ss.model.model.Order;
import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.service.dao.OrderDao;
@Transactional
public class OrderManager {
	private OrderDao dao;

	public void save(Object object){
		dao.save(object);
	}
	
	public void update(Object object){
		dao.update(object);
	}
	
	public void saveorupdate(Object object){
		dao.saveOrUpdate(object);
	}
	
	public void saveAll(List<Product> list){
		dao.saveAll(list);
	}

	public List<Order> getMyOrders(Long userId){
		return dao.getMyOrders(userId);
	}
	
	public List<Order> searchOrder(Date startDate,Date endDate,Long status){
		return dao.searchOrder(startDate, endDate, status);
	}
	
	public OrderDao getDao() {
		return dao;
	}

	public void setDao(OrderDao dao) {
		this.dao = dao;
	}
	

	
}
