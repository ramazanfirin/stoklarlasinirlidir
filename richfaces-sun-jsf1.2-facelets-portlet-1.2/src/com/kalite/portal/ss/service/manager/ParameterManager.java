package com.kalite.portal.ss.service.manager;

import java.util.List;

import com.kalite.portal.ss.model.model.OrderStatus;
import com.kalite.portal.ss.service.dao.ParameterDao;

public class ParameterManager {
	private ParameterDao dao;

	public List<OrderStatus> getOrderStatusList(){
		return dao.getOrderStatusList();
	}
	
	
	
	
	
	
	public ParameterDao getDao() {
		return dao;
	}

	public void setDao(ParameterDao dao) {
		this.dao = dao;
	}
}
