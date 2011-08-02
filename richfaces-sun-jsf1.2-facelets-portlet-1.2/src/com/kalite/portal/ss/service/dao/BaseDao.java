package com.kalite.portal.ss.service.dao;

import java.util.Iterator;
import java.util.List;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.kalite.portal.ss.model.model.Product;

public class BaseDao extends HibernateDaoSupport{
	public void delete(Object object) {
		getHibernateTemplate().delete(object);
		
	}

	public void save(Object object) {
		getHibernateTemplate().save(object);
		
	}

	public void saveOrUpdate(Object object) {
		getHibernateTemplate().saveOrUpdate(object);
		
	}

	public void update(Object object) {
		getHibernateTemplate().update(object);
		
	}
	
	public void saveAll(List<Product> list){
		for (Iterator iterator = list.iterator(); iterator.hasNext();) {
			Object object = (Object) iterator.next();
			saveOrUpdate(object);
		}
		
	}

}
