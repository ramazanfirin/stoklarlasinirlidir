package com.kalite.portal.ss.service.dao;

import java.util.Date;
import java.util.List;

import org.hibernate.Query;

import com.kalite.portal.ss.model.model.Order;

public class OrderDao extends BaseDao{
	
	public List<Order> getMyOrders(Long userId){
		String hql =  "select i from Order i where i.userId=:userId";
		Query query = getSession().createQuery(hql);
		query.setParameter("userId", userId);
		List<Order> list=query.list();
		return list;    
	}
	
	public List<Order> searchOrder(Date startDate,Date endDate,Long status){
		String hql =  "select i from Order i where i.insertDate<=:startDate and i.insertDate>:endDate";
		if(status==null)
			hql=hql+" and i.status.id=:status";
		Query query = getSession().createQuery(hql);
		query.setDate("startDate", startDate);
		query.setDate("endDate", endDate);
		if(status==null)
			query.setLong("status",status);
		List<Order> list=query.list();
		return list;    
	}
}
