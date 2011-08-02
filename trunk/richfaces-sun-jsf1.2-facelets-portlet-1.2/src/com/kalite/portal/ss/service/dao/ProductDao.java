package com.kalite.portal.ss.service.dao;

import java.util.List;

import com.kalite.portal.ss.model.model.Product;

public class ProductDao extends BaseDao{
	
	public void deleteAll(List<Product> list){
		getHibernateTemplate().deleteAll(list);
	}

	public List<Product> getActiveProducts(){
		List<Product> list=getHibernateTemplate().find("from Product");
		return list;
	}
	
	public Product findProduct(Long id){
		List<Product> list=getHibernateTemplate().   find("from Product where id="+id);
		if(list.size()>0)
		    return list.get(0);
		else
			return null;
	}
}
