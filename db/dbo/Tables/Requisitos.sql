-- =====================================================
-- Object:  Table [dbo].[Requisitos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Requisitos] (
    [ID] [int] IDENTITY(1,1) NOT NULL,
    [Descripcion] [varchar](255) NOT NULL,
    [CategoriaID] [int] NOT NULL,
    [PrioridadID] [int] NOT NULL,
    [Fecha] [date] NOT NULL DEFAULT GETDATE(),
	
    CONSTRAINT PK_Requisitos PRIMARY KEY CLUSTERED ([ID] ASC),
    CONSTRAINT FK_Requisitos_Categoria FOREIGN KEY ([CategoriaID]) 
        REFERENCES [dbo].[CategoriasRequisitos] ([ID]) 
        ON DELETE CASCADE,
    CONSTRAINT FK_Requisitos_Prioridad FOREIGN KEY ([PrioridadID]) 
        REFERENCES [dbo].[Categorias] ([ID]) 
        ON DELETE CASCADE
) ON [PRIMARY];