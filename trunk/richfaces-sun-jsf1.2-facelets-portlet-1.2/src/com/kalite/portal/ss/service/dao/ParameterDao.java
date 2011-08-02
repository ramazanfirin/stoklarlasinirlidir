package com.kalite.portal.ss.service.dao;

import java.util.List;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.kalite.portal.ss.model.model.OrderStatus;
@SuppressWarnings("unchecked")
public class ParameterDao extends HibernateDaoSupport{
	
	public List<OrderStatus> getOrderStatusList(){
		List<OrderStatus> list=getHibernateTemplate().find("select p from OrderStatus p");
		return list;
	}
	
}