package com.kalite.portal.ss.service.manager;

import java.util.List;

import org.springframework.transaction.annotation.Transactional;

import com.kalite.portal.ss.model.model.Product;
import com.kalite.portal.ss.service.dao.BasketDao;
@Transactional
public class BasketManager {
	private BasketDao dao;

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

	public BasketDao getDao() {
		return dao;
	}

	public void setDao(BasketDao dao) {
		this.dao = dao;
	}
	

	
}
